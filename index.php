<?
include_once 'config/Config.php';
Config::setTitol('Inici');

ini_set('date.timezone', 'Europe/Madrid');
date_default_timezone_set('Europe/Madrid');
setlocale(LC_ALL, 'ca_ES.UTF-8');

include 'view/components/header.php';