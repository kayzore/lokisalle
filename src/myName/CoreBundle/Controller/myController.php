<?php
namespace src\myName\CoreBundle\Controller;


use kayzore\bundle\KBundle\Controller;

class myController extends Controller
{
    public function homeAction() {
        echo $this->twig->render('test.html.twig', array(
            'message'       => 'Home page',
            'current_url'   => $this->getUrl('public.ls_homepage')
        ));
    }

    public function contactAction() {
        echo $this->twig->render('test.html.twig', array(
            'message'       => 'Page de contact, methode POST',
            'current_url'   => $this->getUrl('public.ls_contact')
        ));
    }

    public function testAction($id) {
        echo $this->twig->render('test.html.twig', array(
            'message'       => 'Page de test',
            'id'            => $id,
            'current_url'   => $this->getUrl('public.ls_test')
        ));
    }

    public function test2Action($id) {
        echo $this->twig->render('test.html.twig', array(
            'message'       => 'Page de test 2',
            'id'            => $id,
            'current_url'   => $this->getUrl('public.ls_test2')
        ));
    }
}