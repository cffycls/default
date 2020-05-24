<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::addGroup('/v1', function (){
    Router::post('/login', 'App\Controller\v1\Login@login');
    Router::addGroup('/users', function (){
        Router::get('[/]', 'App\Controller\v1\Users@all');
        Router::get('/{id}', 'App\Controller\v1\Users@get');
        Router::post('[/]', 'App\Controller\v1\Users@create');
        Router::put('[/]', 'App\Controller\v1\Users@update');
        Router::delete('[/]', 'App\Controller\v1\Users@delete');

    }, ['middleware' => [\App\Middleware\v1\Oauth::class]]);

});
