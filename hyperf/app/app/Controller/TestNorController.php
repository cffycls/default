<?php


namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * Class TestNorController
 * @Controller()
 */
class TestNorController
{
    /**
     * http://127.0.0.1:9501/test_nor/index
     * 方法改名
     * @RequestMapping(path="index", methods="post")
     * @param RequestInterface $request
     * @return array
     */
    public function add(RequestInterface $request)
    {
        $post = $request->query();
        return [__FUNCTION__, $post];
    }

    /**
     * curl http://127.0.0.1:9501/test_update -w "\ntime_connect:%{time_connect}\nhttp_code:%{http_code}\n" -X PUT -d "id=66"
     * @RequestMapping(path="/test_update", methods={"get","head","PUT"})
     * @param RequestInterface $request
     * @return array
     */
    public function update(RequestInterface $request)
    {
        $input = $request->input('id', 'id?');
        return [__FUNCTION__, $input];
    }

}