<?php

define('ROOT_PATH', '');
require_once ROOT_PATH . 'define.php';

$session=(isset($_GET['session']) ? $_GET['session'] : ((isset($_POST['session'])) ? $_POST['session'] : session_id()) ) ;
$session = htmlentities($session);

include_once ROOT_PATH .'fonctions_conges.php';
include_once INCLUDE_PATH .'fonction.php';
$add_css = NULL;
header_menu('', 'Libertempo : '._('calendrier_titre'), $add_css);
echo \calendrier\Fonctions::calendrierModule($session);
bottom();
