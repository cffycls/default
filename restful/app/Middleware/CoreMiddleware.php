<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ServerRequestInterface;

class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware
{
    //Hyperf\HttpServer\CoreMiddleware::class => App\Middleware\CoreMiddleware::class,    #dependencies.php覆盖原方法
    protected function handleNotFound(ServerRequestInterface $request)
    {
        // 重写路由找不到的处理逻辑
        return $this->response()->withStatus(404)->withBody(new SwooleStream('page not found...'));
    }

    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request)
    {
        // 重写 HTTP 方法不允许的处理逻辑
        return $this->response()->withStatus(405)->withBody(new SwooleStream('operate not found...'));
    }

}