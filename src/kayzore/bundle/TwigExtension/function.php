<?php

$get_route_function = new Twig_SimpleFunction('getRoute', function ($name, array $options = []) {
    return $this->getUrl($name, $options);
});

$get_assets = new Twig_SimpleFunction('assets', function ($path) {
    return $_SESSION[kFramework::getProjectAlias() .'_viewVar']['racineWeb'] . $path;
});

$this->twig->addFunction($get_route_function);
$this->twig->addFunction($get_assets);