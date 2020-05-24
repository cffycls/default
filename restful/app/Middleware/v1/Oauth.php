<?php

declare(strict_types=1);

namespace App\Middleware\v1;

use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @AutoController()
 * Class Oauth
 * @package App\Middleware\v1
 */
class Oauth implements MiddlewareInterface
{
    /**
     * @Inject()
     * @var SessionInterface $session
     */
    private $session;
    /**
     * @Inject()
     * @var \Hyperf\HttpServer\Contract\ResponseInterface $response
     */
    protected $response;

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        echo $request->getRequestTarget() .PHP_EOL;
        if ($request->getRequestTarget() == '/v1/users/login' || $this->session->has('id') && $this->session->get('token')){
            echo 'passed' .PHP_EOL;
            return $handler->handle($request);
        }
        return $this->response->withBody(new SwooleStream(json_encode(['error' => '中间里验证token无效，阻止继续向下执行'], JSON_UNESCAPED_UNICODE)));
    }

}