<?php
/**
 * Этот файл является частью расширения модуля веб-приложения GearMagic.
 * 
 * Файл конфигурации расширения.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    'translator' => [
        'locale'   => 'auto',
        'patterns' => [
            'text' => [
                'basePath' => __DIR__ . '/../lang',
                'pattern'   => 'text-%s.php'
            ]
        ],
        'autoload' => ['text'],
        'external' => [BACKEND]
    ],

    'accessRules' => [
        // для авторизованных пользователей панели управления
        [ // разрешение "Полный доступ" (any)
            'allow',
            'permission'  => 'any',
            'controllers' => [
                'Page' => ['index']
            ],
            'users' => ['@backend']
        ],
        [ // разрешение "Информация о расширении" (info)
            'allow',
            'permission'  => 'info',
            'controllers' => ['Info'],
            'users'       => ['@backend']
        ],
        [ // для всех остальных, доступа нет
            'deny'
        ]
    ],

    'viewManager' => [
        'id'          => 'gm-config-version-{name}',
        'useTheme'    => true,
        'useLocalize' => true,
        'viewMap'     => [
            // информация о расширении
            'info' => [
                'viewFile'      => '//backend/extension-info.phtml', 
                'forceLocalize' => true
            ],
            'page' => '/page.phtml'
        ]
    ]
];
