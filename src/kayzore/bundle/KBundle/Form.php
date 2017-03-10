<?php
namespace kayzore\bundle\KBundle;


class Form
{
    public static function sanitizePost()
    {
        self::sanitizeArray($_POST);
    }
    
    private function sanitizeValue(&$value)
    {
        $value = trim(strip_tags($value));
    }

    private function sanitizeArray(array &$array)
    {
        array_walk($array, array($this,'sanitizeValue'));
    }
}