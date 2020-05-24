<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\AbstractController;
use Hyperf\DB\DB;
use Hyperf\Utils\ApplicationContext;

/**
 * Class Users
 * @package App\Controller\v1
 */
class Users extends AbstractController
{
    public function test()
    {
        return $this->response->raw('Hello Hyperf!');
    }

    protected $db;
    public function __construct()
    {
        $this->db = ApplicationContext::getContainer()->get(DB::class);
    }

    public function all()
    {
        $currentPage = (int) $this->request->input('page', 1);
        $perPage = (int) $this->request->input('per_page', 50);
        $query = 'SELECT id,name,birthday,ip_address FROM `users` LIMIT ' .$currentPage .','. $perPage;
        echo $query. PHP_EOL;
        return $this->response->json($this->db->query($query));
    }

    //路由使用和get有冲突
    public function allByGroupId($group_id)
    {
        $query = 'SELECT id,name,birthday,ip_address FROM `users` WHERE group_id=' .$group_id;
        echo $query. PHP_EOL;
        return $this->response->json($this->db->query($query));
    }

    //路由使用和get有冲突
    public function allByName($name)
    {
        $query = "SELECT id,name,birthday,ip_address FROM `users` WHERE name like '" .$name ."%'";
        echo $query. PHP_EOL;
        return $this->response->json($this->db->query($query));
    }

    public function get($id)
    {
        if (!is_numeric($id)){
            $query = "SELECT id,name,birthday,ip_address FROM `users` WHERE name like '" .$id ."%'";
        }else{
            $query = 'SELECT id,name,birthday,ip_address FROM `users` WHERE id=' .$id;
        }
        echo $query. PHP_EOL;
        return $this->response->json($this->db->query($query));
    }

    public function create()
    {
        $query = "INSERT INTO `users` (name,password,group_id,intro,ip_address) VALUES ('" .$this->request->post('name'). "','"
            .strtoupper(md5($this->request->server('request_time') .'')) ."'," .$this->request->post('group_id') .
            ",'" .$this->request->post('intro') ."','" .$this->request->server('remote_addr') ."')";
        $res = $this->db->execute($query);
        echo $query. PHP_EOL;
        return $this->response->json(['status'=>$res]);
    }

    public function update()
    {
        $query = "UPDATE `users` SET group_id=" .$this->request->post('group_id') .",ip_address='" .$this->request->server('remote_addr').
            "' WHERE id=" .(int) $this->request->post('id');
        $res = $this->db->execute($query);
        echo $query. PHP_EOL;
        return $this->response->json(['status'=>$res]);
    }

    public function delete()
    {
        $query = 'DELETE FROM `users` WHERE ID=' .(int) $this->request->input('id', 0);
        $res = $this->db->execute($query);
        echo $query. PHP_EOL;
        return $this->response->json(['status'=>$res]);
    }


}
