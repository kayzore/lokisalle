<?php
namespace src\jerome\CoreBundle\Controller;


use kayzore\bundle\KBundle\Controller;

class CoreController extends Controller
{
    public function homeAction() {
        echo $this->twig->render('test.html.twig', array(
            'message'       => 'Home page',
            'current_url'   => $this->getUrl('public.ls_homepage')
        ));
    }
}