<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 跨域中间件 -2
 * Context::set 中间件数据传送
 */
class FooMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        var_export([__CLASS__ => [
            'global'=>$request->getAttribute('global'),
            'test1'=>$request->getAttribute('test1'),
            'test2'=>$request->getAttribute('test2')
        ]]);
        // $request 和 $response 为修改后的对象
        $request = Context::set(ServerRequestInterface::class, $request->withAttribute('foo', 'test2 set into value a...'));

        $response = $handler->handle($request);
        $body = $response->getBody()->getContents();
        echo __CLASS__ .__LINE__.PHP_EOL;
        return $response->withBody(new SwooleStream($body. PHP_EOL. ' in func see Foo deal.'));
    }
}