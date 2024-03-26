<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Router;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;
use Authentication\Middleware\AuthenticationMiddleware;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use  `$this` to reference the application class instance
 * if required.
 */

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);
    $routes->setExtensions(['json', 'xml']);

    Router::scope('/', function ($routes) {

        $routes->registerMiddleware('auth', new AuthenticationMiddleware($this));
        $routes->applyMiddleware('auth');

        // Articles Endpoints
        $routes->get('/articles.json', ['controller' => 'Articles', 'action' => 'index']);
        $routes->get('/articles/:id.json', ['controller' => 'Articles', 'action' => 'view'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);
        $routes->post('/articles.json', ['controller' => 'Articles', 'action' => 'add']);
        $routes->put('/articles/:id.json', ['controller' => 'Articles', 'action' => 'edit'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);
        $routes->delete('/articles/:id.json', ['controller' => 'Articles', 'action' => 'delete'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        // Authentication Endpoints
        $routes->post('/user/register', ['controller' => 'Users', 'action' => 'register']);
        $routes->post('/user/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->delete('/user/logout', ['controller' => 'Users', 'action' => 'logout']);

        // Like Endpoints
        $routes->get('/likes/:id', ['controller' => 'Likes', 'action' => 'view'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);
        $routes->post('/likes', ['controller' => 'Likes', 'action' => 'countLikes']);
    });
};
