<?php
declare (strict_types = 1);


namespace app\api\controller;

use think\facade\Db;
use think\Request;

class User
{

    /**
     * @var \think\Request Request实例
     */
    protected $request;

    /**
     * @param Request $request Request对象
     * @access public
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        //路由
        $method = strtoupper($request->method());
        $action = $request->action();
        //var_dump([$action, $method]);
        if($action=='select' && $method=='GET'){

        }elseif($action=='add' && $method=='POST'){

        }elseif($action=='add' && $method=='POST'){

        }elseif($action=='delete' && $method=='DELETE'){

        }elseif($action=='update' && $method=='PUT'){

        }else{
            exit;
        }
    }
    /**
     * @param Request $request Request对象
     * @access public
     */
    public function index(Request $request)
    {
        var_dump($request->method(), $request->action());
        return "hh";
    }

    public function add()
    {
        $name = $this->request->param('name');
        $request_time = $this->request->server('request_time');
        $last_login = date("Y-m-d H:i:s", $request_time);
        //var_dump($last_login);
        $password = md5($last_login). rand(1000,9999);
        $data = [
            'name'=>$name,
            'password'=>$password,
            'last_login'=>$last_login,
        ];
        return Db::name('user')->insert($data);
    }

    public function delete()
    {
        $name = $this->request->param('name');
        return Db::name('user')->where('name',$name)->delete();
    }

    public function update()
    {
        $name = $this->request->param('name');
        $request_time = $this->request->server('request_time');
        $last_login = date("Y-m-d H:i:s", $request_time);
        $data = [
            'last_login'=>$last_login,
        ];
        return Db::name('user')->where('name',$name)->update($data);
    }

    public function select()
    {
        $name = $this->request->param('name');
        return Db::name('user')->where('name',$name)->find();
    }

    public function get()
    {
        $name = $this->request->param('name');
        return Db::name('user')->where('name',$name)->find();
    }

}