<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Admin\Controller\IndexController;
use Admin\Lib\AdminNavigationFactory;
use Zend\Navigation\Service\DefaultNavigationFactory;

return [
    'controllers' => [
        'factories' => [
            'Admin\Controller\Category' => 'Admin\Controller\Factory\AdminControllerFactory'
        ],
        'invokables' => [
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Category' => 'Admin\Controller\CategoryController',
            'Admin\Controller\Article' => 'Admin\Controller\ArticleController',
        ],

    ],
    'router' => [
        'routes' => [
            'admin' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/admin/',
                    'defaults' => [
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'category' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => 'category/[:action/][:id/]',
                            'defaults' => [
                                'controller' => 'Admin\Controller\Category',
                                'action' => 'index'
                            ]
                        ]
                    ],
                    'article' => [

                        'type' => 'segment',
                        'options' => [
                            'route' => 'article/[:action/][:id/]',
                            'defaults' => [
                                'controller' => 'Admin\Controller\Article',
                                'action' => 'index'
                            ]
                        ]
                    ]
                ]
            ],

        ]
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => DefaultNavigationFactory::class,
            'admin_navigation' => AdminNavigationFactory::class
        ]
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Main',
                'route' => 'home'
            ]
        ],
        'admin_navigation' => [
            [
                'label' => 'Admin panel',
                'route' => 'admin',
                'action' => 'index',
                'resource' => IndexController::class,
                'pages' => [
                    [
                        'label' => 'Articles',
                        'route' => 'admin/article',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'Add article',
                        'route' => 'admin/article',
                        'action' => 'add'
                    ],
                    [
                        'label' => 'Categories',
                        'route' => 'admin/category',
                        'action' => 'index'
                    ],
                    [
                        'label' => 'Add category',
                        'route' => 'admin/category',
                        'action' => 'add'
                    ]
                ]
            ],
        ],

    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '../../view',
        ],
        'template_map' => [
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ]
    ],
    'module_layouts' => array(
        'Admin' => 'layout/admin-layout',
    ),
];
