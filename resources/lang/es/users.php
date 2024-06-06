<?php
return [
    'title' => [
            'index' => 'Listado de usuarios',
            'trash' => 'Papelera de usuarios',
            ],

            'roles' => ['admin' => 'Administrador', 'user' => 'Usuario','supervisor'=>'Supervisor'],
            'states' => ['active' => 'Activo', 'inactive' => 'Inactivo'],

    'filters' => [
            'roles' => ['all'=>'Todos', 'admin' => 'Administradores', 'vendedor' => 'Vendedores', 'servicio'=>'Servicio Tecnico','delivery'=>'Repartidor' ],
            'states' => ['all' => 'Todos', 'active' => 'Activos', 'inactive' => 'Inactivos'],
            ],
    'rol' => ['admin' => 'Administrador', 'vendedor' => 'Vendedor', 'servicio'=>'Servicio Tecnico','delivery'=>'Repartidor' ],
    'users'=>[
        'states' => ['active' => 'Activos', 'inactive' => 'Inactivos'],
    ]

];
