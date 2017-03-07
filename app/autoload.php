<?php
spl_autoload_register(function ($classname){
    $file = __DIR__ . '/../' . str_replace('\\', '/', $classname) . '.php';

    include_once $file;
});