<?php

/** Grupo de rotas com Autenticação */
/** @var TYPE_NAME $router */
$router->group(['middleware' => 'auth','prefix' => 'api'], function ($router)
{
    /** Retorna os dados do jornalista */
    $router->get('me', 'AuthController@me');

    /** Grupo de rotas para tipo de notícias */
    $router->group(['prefix' => 'type'], function () use ($router)
    {
        $router->post('create', 'TypeNewsController@create');
        $router->post('update/{id}', 'TypeNewsController@update');
        $router->post('delete/{id}', 'TypeNewsController@delete');
        $router->get('me', 'TypeNewsController@me');

    });

    /** Grupo de rotas para notícias */
    $router->group(['prefix' => 'news'], function () use ($router)
    {
        $router->post('create', 'NewsController@create');
        $router->post('update/{id}', 'NewsController@update');
        $router->post('delete/{id}', 'NewsController@delete');
        $router->get('me', 'NewsController@me');
        $router->get('type/{id}', 'NewsController@findNewsByTypeId');
    });
});

/** Grupo de rotas para criação e login de jornalistas ( Sem Autenticação ) */
$router->group(['prefix' => 'api'], function () use ($router)
{
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});


