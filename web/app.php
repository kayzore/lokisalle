<?php
use kayzore\bundle\KBundle\Configuration;

require_once '../vendor/autoload.php';
require_once '../app/autoload.php';

define('RACINE_WEB', dirname(dirname(__FILE__)) .'\\');
define('DEV_MODE', true);
session_start();
$configuration = new Configuration();