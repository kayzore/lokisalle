<?php
$get_route_function = new Twig_SimpleFunction('getRoute', function ($name, array $options = []) {
    return $this->getUrl($name, $options);
});

$get_assets = new Twig_SimpleFunction('assets', function ($path) {
    return 'http://' . $_SERVER['SERVER_NAME'] . '/' . \kayzore\bundle\KBundle\kFramework::getProjectSubFolder() . '/web/' . $path;
});

$this->twig->addFunction($get_route_function);
$this->twig->addFunction($get_assets);