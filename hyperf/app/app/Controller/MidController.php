<?php


namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use App\Middleware\Test1Middleware;
use App\Middleware\Test2Middleware;
use App\Middleware\FooMiddleware;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * <<9>> 中间件
 * @AutoController()
 * a. 类中间件
 * @Middlewares({
 *     @Middleware(Test1MIddleware::class),
 *     @Middleware(Test2Middleware::class)
 * })
 */
class MidController
{
    /**
     * b. 方法中间件
     * @Middleware(FooMiddleware::class)
     */
    public function index(RequestInterface $request)
    {
        $value_global = $request->getAttribute('global');
        $value_test1 = $request->getAttribute('test1');
        $value_test2 = $request->getAttribute('test2');
        $value_foo = $request->getAttribute('foo');
        var_export(['MidController' => ['global'=>$value_global, 'test1'=>$value_test1, 'test2'=>$value_test2, 'foo'=>$value_foo]]);
        return 'ok';
    }

}