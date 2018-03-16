<?php
/**
работа с Sitemap
 */

namespace Mf\Sitemap;

use Zend\Router\Http\Segment;
use Zend\Router\Http\Literal;

return [
    //маршруты
    'router' => [
        'routes' => [
            'sitemap' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/sitemap/:url',
                    'constraints' => [
                        'url' => '[a-zA-Z0-9_\-]+',
                    ],

                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'    => 'detal',
                    ],
                ],
            ],
            'sitemapintex' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/sitemap',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'    => 'index',
                    ],
                ],
            ],
      ],
    ],
    //контроллеры
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [//сервисы-фабрики
          //Service\GetControllersInfo::class => Service\Factory\GetControllersInfoFactory::class,
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],


];
