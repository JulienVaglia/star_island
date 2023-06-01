<?php
//  fichier de config de l'app

session_start();

const CONFIG=[
    'db'=>[
        'HOST'=>'localhost',
        'PORT'=>'3306',
        'NAME'=>'crud',
        'USER'=>'root',
        'PWD'=>''

    ],
    'app'=>[
        'name'=>'CRUD',
        'projecturl'=>'http://localhost/PHP/03-crud'
    ]

];

const BASE_PATH='/PHP/03-crud/';

