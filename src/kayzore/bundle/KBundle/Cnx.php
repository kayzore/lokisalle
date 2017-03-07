<?php
namespace kayzore\bundle\KBundle;

use PDO;
use Symfony\Component\Yaml\Yaml;

class Cnx
{
    private static $host;
    private static $user;
    private static $password;
    private static $db_name;
    private static $instance;

    private function __construct() {}

    /**
     * @return mixed
     */
    public static function getHost()
    {
        return self::$host;
    }

    /**
     * @param mixed $host
     */
    public static function setHost($host)
    {
        self::$host = $host;
    }

    /**
     * @return mixed
     */
    public static function getUser()
    {
        return self::$user;
    }

    /**
     * @param mixed $user
     */
    public static function setUser($user)
    {
        self::$user = $user;
    }

    /**
     * @return mixed
     */
    public static function getPassword()
    {
        return self::$password;
    }

    /**
     * @param mixed $password
     */
    public static function setPassword($password)
    {
        self::$password = $password;
    }

    /**
     * @return mixed
     */
    public static function getDbName()
    {
        return self::$db_name;
    }

    /**
     * @param mixed $db_name
     */
    public static function setDbName($db_name)
    {
        self::$db_name = $db_name;
    }

    /**
     * Crée une instance de PDO si elle n'existe pas déjà
     * @return PDO
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $config = Yaml::parse(file_get_contents(kFramework::getPathConfig() . 'parameters.yml'));

            self::setHost($config['parameter']['db_host']);
            self::setDbName($config['parameter']['db_name']);
            self::setUser($config['parameter']['db_user']);
            self::setPassword($config['parameter']['db_pass']);

            self::$instance = new  PDO(
                'mysql:dbname=' . self::getDbName() . ';host=' . self::getHost(),
                self::getUser(),
                self::getPassword(),
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return self::$instance;
    }
}