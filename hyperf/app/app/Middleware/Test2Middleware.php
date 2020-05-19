<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Test2Middleware implements MiddlewareInterface
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
        echo '{2}';
        $request->withAttribute('test1', 'test1 test2 value');
        $request = Context::override(ServerRequestInterface::class, function () use ($request) {
            return $request->withAttribute('test2', 'test2 override into value');
        });
        $response = $handler->handle($request);
        echo '{2.1}';
        return $response;
    }
}