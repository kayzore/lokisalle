<?php
namespace kayzore\bundle\KBundle;


use kayzore\bundle\RouterBundle\ServiceException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Controller
{
    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(RACINE_WEB . 'src/views/');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => (DEV_MODE == true ? false : '../twigCache/'),
            'debug' => DEV_MODE
        ));
        include kFramework::getDirBundle() . 'kayzore/bundle/TwigExtension/kf_extension.php';
        include kFramework::getDirBundle() . 'kayzore/bundle/TwigExtension/kf_global.php';
        include kFramework::getDirBundle() . 'kayzore/bundle/TwigExtension/kf_filter.php';
        include kFramework::getDirBundle() . 'kayzore/bundle/TwigExtension/kf_function.php';

        $root = \kayzore\bundle\KBundle\kFramework::getRacineWeb() . 'src/';
        $this->searchAndInclude('extension.php', $root);
        $this->searchAndInclude('global.php', $root);
        $this->searchAndInclude('filter.php', $root);
        $this->searchAndInclude('function.php', $root);
    }

    /**
     * Inclu un fichier d'extension s'il existe
     * @param $filename
     * @param $root
     */
    private function searchAndInclude($filename, $root) {
        $filepath = '';
        $it = new RecursiveDirectoryIterator($root);
        foreach(new RecursiveIteratorIterator($it) as $file){
            if($file->getBasename() === $filename){
                $filepath = $file->getRealPath();
                break;
            }
        }
        if ($filepath !== '') {
            include $filepath;
        }
    }

    /**
     * Recherche et génère une url (si existante) a partir d'un alias de route
     *
     * @param $name string Alias de la route
     * @param $params array Contient les parametres de la route
     * @return string retourne une url
     * @throws ServiceException Exception lorsque aucune route n'est trouvé
     */
    public function getUrl($name, $params = []) {
        $path = null;
        foreach ($_SESSION['ls_list_routes'] as $key => $route) {
            if ($key == $name) {
                if ($route->path == '') {
                    $path = '../../' . \kayzore\bundle\KBundle\kFramework::getProjectSubFolder() . '/';
                } else {
                    $path = $route->path;
                }
                $path = $this->replaceParams($params, $path);
            }
        }
        if ($path == null) {
            new ServiceException(404, 'No matching routes for generating : ' . $name);
        }
        return $path;
    }

    /**
     * Remplace les paramètres d'une url
     *
     * @param $params array Contient les paramètres de la route
     * @param $path string Route (brut)
     * @return string Url complète
     */
    public function replaceParams($params, $path){
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    /**
     * Effectue une redirection
     * @param $path string Alias d'une route
     */
    public function redirect($path) {
        header('location: ' . $_SESSION[kFramework::getProjectAlias() . '_viewVar']['racineWeb'] . $this->getUrl($path));
        die;
    }

    /**
     * Check si la requête HTTP est une requête ajax
     * @return bool
     */
    public function isXmlHttpRequest() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false);
    }
}