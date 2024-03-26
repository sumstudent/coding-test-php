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
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->setExtensions(['json', 'xml']);

    Router::scope('/', function ($routes) {
        /**
         * Will display all articles from database into json format
         */
        $routes->get('/articles.json', ['controller' => 'Articles', 'action' => 'index', '_ext' => 'json']);

        /**
         * Will display a single article from database into json format using id of the article
         */
        $routes->get('/articles/{id}.json', ['controller' => 'Articles', 'action' => 'view', '_ext' => 'json'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);
        /**
         * If request is post this will route is occur
         */
        $routes->post('/articles/add', ['controller' => 'Articles', 'action' => 'add']);
        //$routes->post('/articles.json', ['controller' => 'Articles', 'action' => 'add', '_ext' => 'json']);

        //Auth API
        $routes->registerMiddleware('auth', new AuthenticationMiddleware($this));
        $routes->applyMiddleware('auth');
        $routes->post('/user/register', ['controller' => 'Users', 'action' => 'register']);
        $routes->post('/user/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->delete('/user/logout', ['controller' => 'Users', 'action' => 'logout']);
    });







    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');

        $builder->resources('Articles');
        $builder->fallbacks();
    });
};
