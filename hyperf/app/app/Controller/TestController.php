<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @AutoController()
 */
class TestController
{
    public function index(RequestInterface $request)
    {
        /**
         * GET/POST
         * http://127.0.0.1:9501 /test/index
         */
        // 从请求中获得 id 参数 put\post
        $id = (int) $request->query('id', 100);
        return __FUNCTION__. ': ' .$id;
    }

    //Hyperf 会自动为此方法生成一个 /index/index 的路由，允许通过 GET 或 POST 方式请求
    /** 自动路由不能自定义路径和方法
     * @RequestMapping(methods="put,post")
     */
    public function map(RequestInterface $request)
    {
        $req = $request->query();
        return [__FUNCTION__, $req];
    }

}