<?php
namespace src\jerome\CoreBundle\Controller;


use jerome\CoreBundle\Model\Membre;
use kayzore\bundle\KBundle\Controller;

class CoreController extends Controller
{
    public function homeAction()
    {
        echo $this->twig->render('front/accueil.html.twig', array(
            'membres' => Membre::fetchAll()
        ));
    }

    public function connexionAction()
    {
        // Connexion
        Membre::connexion('johndoe', 'johndoe');
    }

    public function executeConnexionAction()
    {
        // Execute Connexion
    }

    public function deconnexionAction()
    {
        Membre::deconnexion();
        $this->redirect('public.ls_connexion');
    }
}