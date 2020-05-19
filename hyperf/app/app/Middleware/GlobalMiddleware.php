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
 * 跨域中间件 -1
 * Context::override 中间件数据传送
 */
class GlobalMiddleware implements MiddlewareInterface
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
        echo '{0}';
        $request = Context::override(ServerRequestInterface::class, function () use ($request) {
            return $request->withAttribute('global', 'global into value');
        });

        $response = $handler->handle($request);
        echo '{0.1}';
        $body = $response->getBody()->getContents();
        return $response->withBody(new SwooleStream('['. PHP_EOL. $body. PHP_EOL. ' this is global middleware. '.PHP_EOL.']'));
    }
}