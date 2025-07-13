<?php
return [
    'app' => [
        [
            'header' => 'Project_name',
        ],
        [
            'name' => "Administração",
            "icon" => "fas fa-building",
            'submenu' => [
                [
                    "name" => "Dashboard",
                    "route" => "administracao.home",
                ],
                [
                    "name" =>  "Usuários",
                    "route" => "administracao.user.index",
                ],
            ]
        ],
    ],

    'sistema' => [
        [
            'header' => 'Informações do Sistema',
        ],
        [
            "name" =>  "Início do Sistema",
            "icon" => "fas fa-cogs",
            "route" => "sistema.home",
        ],
        [
            "name" =>  "Usuários",
            "icon" => "fas fa-users",
            "route" => "administracao.user.index",
        ],
        [
            "name" =>  "Permissões",
            "icon" => "fas fa-eye",
            "route" => "sistema.permission.index",
        ],
        [
            "name" =>  "Auditoria",
            "icon" => "fas fa-calendar-check",
            "route" => "sistema.auditoria.operacoes",
        ],
        [
            "name" =>  "Acessos",
            "icon" => "fas fa-door-open",
            "route" => "sistema.auditoria.acessos",
        ],
    ]
];
