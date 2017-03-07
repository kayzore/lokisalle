<?php
namespace kayzore\bundle\RouterBundle;

use app\AppKernel;
use Symfony\Component\Yaml\Yaml;

class RouterController
{
    private $router;
    private $controller;

    /**
     * Start routes, controller and PDO
     */
    public function __construct() {
        $appKernel = new AppKernel();
        $registerController = $appKernel->registerController();
        foreach ($registerController as $name => $controller) {
            $this->controller[$name] = $controller;
        }
        $this->router = new Router($_GET['url']);
        $this->routes();
        $this->start();
    }

    /**
     * Lance le système de route
     */
    private function start() {
        $this->router->run();
    }

    /**
     * Liste les routes
     *
     * Exemple :
     * $this->router->get('/', function(){
     *      $this->controller->test();
     *      $this->showView($arrayPath);
     * });
     * $this->router->get('/posts/:id/:name', function($id, $name){
     *      $this->controller->test($id, $name);
     *      $this->showView($arrayPath);
     * });
     *
     */
    private function routes() {
        $routing = Yaml::parse(file_get_contents(\kayzore\bundle\KBundle\kFramework::getPathConfig() . 'routing.yml'));
        foreach ($routing as $alias => $value) {
            $methode = $value['methode'] . 'Action';
            $this
                ->router
                ->$value['type'](
                    $value['route'],
                    $value['controller'] . '#' . $methode,
                    $alias
                )
            ;
        }
    }
}