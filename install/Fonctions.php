<?php
namespace install;

/**
 * Regroupement de fonctions d'installation
 */
class Fonctions {
    public static function installationMiseAJour($lang)
    {
        include ROOT_PATH .'version.php' ;
        $installedVersion = self::get_installed_version();
        // @TODO : check admin pour la maj
        if (0 != $installedVersion) {
            $versionLastMaj = self::miseAJour($installedVersion, $config_php_conges_version);
        } else {
            $versionLastMaj = self::installation($config_php_conges_version);
        }
        // Finalisation
        /* Reset du token d'instance à chaque version */
        \includes\SQL::query('UPDATE `conges_appli` SET appli_valeur =  "' . hash('sha256', time() . rand()) . '" WHERE appli_variable = "token_instance"');

        $sql_update_version="UPDATE conges_config SET conf_valeur = '$config_php_conges_version' WHERE conf_nom = 'installed_version' ";
        \includes\SQL::query($sql_update_version) ;

        $sql_update_lang="UPDATE conges_config SET conf_valeur = '$lang' WHERE conf_nom = 'lang' ";
        \includes\SQL::query($sql_update_lang);

        $sql_update_date = 'UPDATE `conges_appli` SET appli_valeur = "' . $versionLastMaj . '" WHERE appli_variable = "version_last_maj" LIMIT 1';
        \includes\SQL::query($sql_update_date);
    }

    private static function get_installed_version() : string
    {
        try {
            $reglog = $db->query('show tables like \'conges_config\';');
            if( $reglog->num_rows == 0)
                return 0;
            $sql="SELECT conf_valeur FROM conges_config WHERE conf_nom='installed_version' ";
            if ($reglog = $db->query($sql) && $result = $reglog->fetch_array()) {
                return $result['conf_valeur'];
            }
        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }

    private static function installation(string $versionAppli) : string
    {
        foreach (glob(PATCH_PATH . '/*.sql') as $filename) {
            $currentPatch = basename($filename, '.sql');
            execute_sql_file($filename);
        }

        /* Prénommage de l'instance et pointage API */
        self::addInstanceName(\includes\SQL::singleton());

        $comment_log = "Install de php_conges (version = $versionAppli) ";
        log_action(0, "", "", $comment_log);

        return $currentPatch;
    }


    private static function miseAJour(string $installed_version, string $config_php_conges_version) : string
    {
        // Avant tout, une petite protection…
        try {
            \admin\Fonctions::sauvegardeAsFile($installed_version, 'end');
        } catch (\Exception $e) {
            echo 'Abandon de la mise à jour : ' . $e->getMessage();
        }

        $versionDerniereMAJ = self::getVersionDerniereMiseAJour();
        list($major, $minor, $patch) = explode('.', $versionDerniereMAJ);
        foreach (glob(PATCH_PATH . '/' . $major . '.' . $minor . '*.sql') as $filename) {
            $currentPatch = basename($filename, '.sql');
            if (version_compare($currentPatch, $versionDerniereMAJ, '>')) {
                execute_sql_file($filename);
            }
        }

        $comment_log = _('install_maj_titre_2')." (version $installed_version --> version $config_php_conges_version) ";
        log_action(0, "", "", $comment_log);

        return $currentPatch;
    }

    private static function getVersionDerniereMiseAJour() : string
    {
        $db = \includes\SQL::singleton();
        $req = 'SELECT appli_valeur FROM conges_appli WHERE appli_variable = "version_last_maj" LIMIT 1';
        $res = $db->query($req);
        return $res->fetch_array()['appli_valeur'];
    }

    /**
     * Définit les données de configuration pour l'API
     *
     * @param array $data Données de configuration
     *
     * @throws \Exception En cas d'échec d'écriture
     */
    public static function setDataConfigurationApi(array $data)
    {
        $data = [
            'db' => [
                'serveur' => $data['serveur'],
                'base' => $data['base'],
                'utilisateur' => $data['user'],
                'mot_de_passe' => $data['password'],
            ],
        ];
        if (false === file_put_contents(API_SYSPATH . 'configuration.json', json_encode($data))) {
            throw new \Exception('Création du fichier de config API impossible. Les droits sont-ils bien configurés ?');
        }
    }

    /**
     *
     * @param \includes\SQL $db DB
     */
    private static function addInstanceName(\includes\SQL $db) : string
    {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $positionInstall = stripos($url, 'install/');
        if (false === $positionInstall) {
            throw new \Exception("Le logiciel n'est pas installé correctement. veuillez recommencer");
        }
        $instance = mb_substr($url, 0, $positionInstall);

        $requete = 'UPDATE `conges_config` SET conf_valeur = "' . $db->quote($instance) . '"
        WHERE conf_nom = "URL_ACCUEIL_CONGES" LIMIT 1';
        $db->query($requete);
        $path = parse_url($instance, \PHP_URL_PATH);
        $contentFile = file_get_contents(API_PATH . '.htaccess.example');
        $newContent = str_replace('vendor', $path . 'vendor', $contentFile);
        file_put_contents(API_PATH . '.htaccess', $newContent);

        return $instance;
    }
}
