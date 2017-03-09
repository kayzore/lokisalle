<?php
$get_route_function = new Twig_SimpleFunction('getRoute', function ($name, array $options = []) {
    return $this->getUrl($name, $options);
});
$this->twig->addFunction($get_route_function);

$get_assets = new Twig_SimpleFunction('assets', function ($path) {
    return 'http://' . $_SERVER['SERVER_NAME'] . '/' . \kayzore\bundle\KBundle\kFramework::getProjectSubFolder() . '/web/' . $path;
});
$this->twig->addFunction($get_assets);

$user_is_connected = new Twig_SimpleFunction('userIsConnected', function () {
    return (
        isset($_SESSION[\kayzore\bundle\KBundle\kFramework::getProjectAlias(). '_utilisateur']) &&
        !is_null($_SESSION[\kayzore\bundle\KBundle\kFramework::getProjectAlias(). '_utilisateur']) ? true : false
    );
});
$this->twig->addFunction($user_is_connected);