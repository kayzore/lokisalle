<?php
spl_autoload_register(function ($classname){
    $file = __DIR__ . '/../' . str_replace('\\', '/', $classname) . '.php';
    if (!file_exists($file)) {
        $file = '../src/' . str_replace('\\', '/', $classname) . '.php';
    }
    include_once $file;
});