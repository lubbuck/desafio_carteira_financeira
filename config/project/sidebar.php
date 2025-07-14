<?php
return [
    'app' => [
        [
            'header' => 'Sua Carteira',
        ],
        [
            "name" =>  "Início",
            "icon" => "bx bx-home",
            "route" => "home"
        ],
        [
            "name" =>  "Carteiras",
            "icon" => "bx bx-dollar",
            "route" => "carteira.index"
        ],
    ],

    'administracao' => [
        [
            'header' => 'Adminstração',
        ],
        [
            'name' => "Dashboard",
            "icon" => "bx bx-chalkboard",
            "route" => "administracao.home",
        ],
        [
            "name" =>  "Usuários",
            "icon" => "bx bx-group",
            "route" => "administracao.user.index",
        ],
    ],

    'sistema' => [
        [
            'header' => 'Informações do Sistema',
        ],
        [
            "name" =>  "Início do Sistema",
            "icon" => "bx bx-chalkboard",
            "route" => "sistema.home",
        ],
        [
            "name" =>  "Usuários",
            "icon" => "bx bx-group",
            "route" => "administracao.user.index",
        ],
        [
            "name" =>  "Permissões",
            "icon" => "bx bx-show",
            "route" => "sistema.permission.index",
        ],
        [
            "name" =>  "Auditoria",
            "icon" => "bx bx-calendar-check",
            "route" => "sistema.auditoria.operacoes",
        ],
        [
            "name" =>  "Acessos",
            "icon" => "bx bx-door-open",
            "route" => "sistema.auditoria.acessos",
        ],
    ]
];
