<?php
namespace kayzore\bundle\RouterBundle;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Route
{
    public $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
    }

    /**
     * Permet de capturer l'url avec les paramètres
     * get('/posts/:slug-:id') par exemple
     *
     * @param $url
     * @return bool
     *
     */
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call(){
        if(is_string($this->callable)){
            $params = explode('#', $this->callable);
            $root = \kayzore\bundle\KBundle\kFramework::getRacineWeb() . 'src/'; // directory from where to start search
            $toSearch = $params[0].'.php';                   // basename of the file you wish to search
            $filepath = '';
            $it = new RecursiveDirectoryIterator($root);
            foreach(new RecursiveIteratorIterator($it) as $file){
                if($file->getBasename() === $toSearch){
                    $filepath = $file->getRealPath();
                    break;
                }
            }
            $controller = $this->extract_namespace($filepath);
            $controller = $controller . '\\' . $params[0];
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // On retourne toujours l'objet pour enchainer les arguments
    }

    /**
     * Permet de générer des urls
     *
     * @param $params
     * @return mixed|string
     */
    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    private function extract_namespace($file) {
        $ns = NULL;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }
}