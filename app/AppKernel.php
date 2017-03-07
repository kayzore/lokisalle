<?php
namespace app;

class AppKernel
{
    public function registerBundles() {
        return array(
            'CoreBundle' => 'src/myName/CoreBundle/',
        );
    }
    public function registerController() {
        return array(
            'myController' => new \src\myName\CoreBundle\Controller\myController()
        );
    }
    public function registerService() {
        return array(
        );
    }
}