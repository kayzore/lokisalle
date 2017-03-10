<?php
namespace kayzore\bundle\RouterBundle;

use app\AppKernel;
use kayzore\bundle\KBundle\KFramework;
use Symfony\Component\Yaml\Yaml;

class RouterController
{
    private $router;
    private $controller;

    /**
     * Start routes, controller and PDO
     */
    public function __construct()
    {
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
    private function start()
    {
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
    private function routes()
    {
        $path_admin = kFramework::getPathConfig() . 'routing-admin.yml';
        $routing = Yaml::parse(file_get_contents($path_admin));
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
        $routing[] = $_SESSION[kFramework::getProjectAlias() . '_viewVar']['racineWeb'];
        $yaml = Yaml::dump($routing);
        if (!file_put_contents('assets/routing/routing-admin.yml', $yaml)) {
            new ServiceException(500, "La copie $path_admin du fichier a échouée...");
        }

        $path_public = kFramework::getPathConfig() . 'routing.yml';
        $routing = Yaml::parse(file_get_contents($path_public));
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
        $routing[] = $_SESSION[kFramework::getProjectAlias() . '_viewVar']['racineWeb'];
        $yaml = Yaml::dump($routing);
        if (!file_put_contents('assets/routing/routing.yml', $yaml)) {
            new ServiceException(500, "La copie $path_public du fichier a échouée...");
        }
    }
}