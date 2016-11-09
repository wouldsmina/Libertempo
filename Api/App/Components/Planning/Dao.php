<?php
namespace Api\App\Components\Planning;

/**
 * {@inheritDoc}
 *
 * @author Prytoegrian <prytoegrian@protonmail.com>
 * @author Wouldsmina
 *
 * @since 0.1
 *
 * Ne devrait être contacté que par Planning\Repository
 * Ne devrait contacter personne
 */
class Dao extends \Api\App\Libraries\ADao
{
    /*************************************************
     * GET
     *************************************************/

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        $res = $this->storageConnector->prepare(
            'SELECT *
            FROM ' . $this->getTableName() . '
            WHERE planning_id = :id'
        );
        $res->execute([
            ':id' => (int) $id,
        ]);

        return $res->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(array $parametres)
    {
        $req = 'SELECT * FROM ' . $this->getTableName();
        $filters = $this->getFilters($parametres);
        $req .= $filters['where'];
        if (!empty($parametres['limit'])) {
            $req .= ' LIMIT 0,' . $parametres['limit'];
        }
        $res = $this->storageConnector->prepare($req);
        $res->execute($filters['bind']);

        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retourne le tableau des filtres à appliquer à la requête
     *
     * @param array $parametres
     * @example [filter => [], lt => 23, limit => 4]
     *
     * @return array ['where' => clause complète, 'bind' => variables[]]
     */
    private function getFilters(array $parametres)
    {
        $where = [];
        $bind = [];
        if (!empty($parametres['lt'])) {
            $where[] = 'planning_id < :lt';
            $bind[':lt'] = $parametres['lt'];
        }
        if (!empty($parametres['gt'])) {
            $where[] = 'planning_id > :gt';
            $bind[':gt'] = $parametres['gt'];
        }

        return [
            'where' => !empty($where)
                ? ' WHERE ' . implode(' AND ', $where)
                : '',
            'bind' => $bind,
        ];
    }

    /*************************************************
     * POST
     *************************************************/

    /**
     * @inheritDoc
     */
    public function post(array $data)
    {
    }

    /**
     * {@inheritDoc}
     */
    final protected function getTableName()
    {
        return 'planning';
    }
}