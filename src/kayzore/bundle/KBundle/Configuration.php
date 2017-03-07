<?php
namespace kayzore\bundle\KBundle;

use kayzore\bundle\RouterBundle\RouterController;

/**
 * Initialisation du Framework
 * Class Configuration
 * @package kayzore\bundle\KBundle
 */
class Configuration extends RouterController
{
    public function __construct()
    {
        kFramework::setRacineWeb(str_replace('\\', '/', RACINE_WEB)); // C:\wamp64\www\jl\KFramework\

        if (is_dir('../src/kayzore/bundle/KBundle/')) {
            kFramework::setDirBundle(kFramework::getRacineWeb() . 'src/');
        } else {
            kFramework::setDirBundle(kFramework::getRacineWeb() . 'vendor/kayzore/phpframework/src/');
        }

        // PROJECT INFORMATIONS
        kFramework::setPathConfig(kFramework::getRacineWeb() . 'app/config/');

        // PARENT
        parent::__construct();
    }
}