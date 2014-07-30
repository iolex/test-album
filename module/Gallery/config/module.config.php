<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Gallery\Controller\Album' => 'Gallery\Controller\AlbumController',
            'Gallery\Controller\Photo' => 'Gallery\Controller\PhotoController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'Gallery' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/gallery',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Gallery\Controller',
                        'controller'    => 'Album',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Gallery' => __DIR__ . '/../view',
        ),
    ),
);
