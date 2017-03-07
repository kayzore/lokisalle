<?php
namespace kayzore\bundle\RouterBundle;

use Exception;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class ServiceException
{
    public function __construct($type, $message) {
        switch ($type) {
            case 404:
                @set_exception_handler(array($this, 'exception_404'));
                break;
            case 500:
                @set_exception_handler(array($this, 'exception_500'));
                break;
        }
        throw new Exception($message);
    }

    public function exception_404(Exception $exception) {
        $title = '404 Not Found';
        $message = '<h1>404 Not Found</h1>' . $exception->getMessage();
        $this->showException($title, $message);
    }

    public function exception_500(Exception $exception) {
        $title = '500 Internal Error';
        $message = '<h1>500 Internal Error</h1>' . $exception->getMessage();
        $this->showException($title, $message);
    }

    public function showException($title, $message) {
        echo $message;
        /*
        // Instanciation de Twig
        $loader = new Twig_Loader_Filesystem(DIR_VIEW_ERROR);
        // Paramètres twig

        $twig = new Twig_Environment($loader, array(
            'cache' => false,
            'debug' => true,
        ));

        $twig->addExtension(new Twig_Extension_Debug());
        echo $twig->render('error.html.twig', array(
            'title'     => $title,
            'message'   => $message
        ));
        */
    }
}