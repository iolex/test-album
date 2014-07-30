<?php

namespace Gallery;

use Gallery\Model\AlbumModel;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Gallery\Model\AlbumModel' => function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    return new AlbumModel($tableGateway);
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('album', $dbAdapter);
                },
                
                /*'Gallery\Model\PhotoModel' => function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    return new AlbumModel($tableGateway);
                },
                'PhotoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('photo', $dbAdapter);
                },*/
            ),
        );
    }
}
