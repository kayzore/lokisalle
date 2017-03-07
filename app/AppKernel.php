<?php
namespace app;

class AppKernel
{
    public function registerBundles() {
        return array(
            'CoreBundle' => 'src/jerome/CoreBundle/',
        );
    }
    public function registerController() {
        return array(
            'CoreController' => new \src\jerome\CoreBundle\Controller\CoreController()
        );
    }
    public function registerService() {
        return array(
        );
    }
}