<?php
/**
 * ----------------------------------------------------
 * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
 * | Сайт: www.rznw.ru                                 |
 * | Телефон: +7 (4912) 51-10-23                       |
 * | Дата: 10.02.16
 * ----------------------------------------------------
 *
 */
return [
    'mediator' => [
        'channels' => [
            'log' => [
                'invokable' => 'Rzn\BitrixLog\Log',
                'injector' => [
                    'file' => [
                        'handler' => 'setter',
                        'options' => [
                            'set' => 'params',
                            'param' => 'local/log.txt',
                            'method' => 'setFile'
                        ]
                    ],
                    'nax_size' => [
                        'handler' => 'setter',
                        'options' => [
                            'set' => 'params',
                            'param' => 1048576,
                            'method' => 'setMaxSize'
                        ]
                    ],
                    'active' => [
                        'handler' => 'setter',
                        'options' => [
                            'set' => 'params',
                            'params' => true,
                            'method' => 'setActive'
                        ]
                    ],

                ]
            ]
        ]
    ]
];
