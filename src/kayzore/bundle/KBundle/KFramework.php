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
    protected static $project_name;
    protected static $project_alias;
    protected static $project_sub_folder;

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

    /**
     * @return mixed
     */
    public static function getProjectName()
    {
        return self::$project_name;
    }

    /**
     * @param mixed $project_name
     */
    public static function setProjectName($project_name)
    {
        self::$project_name = $project_name;
    }

    /**
     * @return mixed
     */
    public static function getProjectAlias()
    {
        return self::$project_alias;
    }

    /**
     * @param mixed $project_alias
     */
    public static function setProjectAlias($project_alias)
    {
        self::$project_alias = $project_alias;
    }

    /**
     * @return mixed
     */
    public static function getProjectSubFolder()
    {
        return self::$project_sub_folder;
    }

    /**
     * @param mixed $project_sub_folder
     */
    public static function setProjectSubFolder($project_sub_folder)
    {
        self::$project_sub_folder = $project_sub_folder;
    }
}