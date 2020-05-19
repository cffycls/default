<?php


namespace app\newapi\controller;

use think\Request;

/**
 * api 入口文件基类，需要控制权限的控制器都应该继承该类
 */
class Newapi
{
    /**
     * @var \think\Request Request实例
     */
    protected $request;

    protected $clientInfo;

    /**
     * 不需要鉴权方法
     */
    protected $noAuth = [];

    /**
     * 构造方法
     * @param Request $request Request对象
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init();
        $this->uid = $this->clientInfo['uid'];

    }

    /**
     * 初始化
     * 检查请求类型，数据格式等
     */
    public function init()
    {
        //所有ajax请求的options预请求都会直接返回200，如果需要单独针对某个类中的方法，可以在路由规则中进行配置
        if ($this->request->isOptions()) {

            self::returnMsg(200, 'success');
        }
        if (!Oauth::match($this->noAuth)) {               //请求方法白名单
            $oauth = app('app\api\controller\Oauth');   //tp5.1容器，直接绑定类到容器进行实例化
            return $this->clientInfo = $oauth->authenticate();;
        }

    }
    /**
     * 返回成功
     */
    public static function returnMsg($code = 200,$message = '',$data = [],$header = [])
    {
        http_response_code($code);    //设置返回头部
        $return['code'] = (int)$code;
        $return['message'] = $message;
        $return['data'] = is_array($data) ? $data : ['info'=>$data];
        // 发送头部信息
        foreach ($header as $name => $val) {
            if (is_null($val)) {
                header($name);
            } else {
                header($name . ':' . $val);
            }
        }
        exit(json_encode($return,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 空方法
     */
    public function _empty()
    {
        self::returnMsg(404, 'empty method!');
    }
}