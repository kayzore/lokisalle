<?php
namespace kayzore\bundle\KBundle;

/**
 * Nomenclature du Framework
 * Class KFramework
 * @package kayzore\bundle\KBundle
 */
abstract class KFramework
{
    protected static $pathConfig;
    protected static $racine_web;
    protected static $dir_bundle;

    /**
     * @return string
     */
    public static function getRacineWeb()
    {
        return self::$racine_web;
    }

    /**
     * @param string $racine_web
     */
    public static function setRacineWeb($racine_web)
    {
        self::$racine_web = $racine_web;
    }

    /**
     * @return string
     */
    public static function getDirBundle()
    {
        return self::$dir_bundle;
    }

    /**
     * @param string $dir_bundle
     */
    public static function setDirBundle($dir_bundle)
    {
        self::$dir_bundle = $dir_bundle;
    }

    /**
     * @return string
     */
    public static function getPathConfig()
    {
        return self::$pathConfig;
    }

    /**
     * @param string $pathConfig
     */
    public static function setPathConfig($pathConfig)
    {
        self::$pathConfig = $pathConfig;
    }
}