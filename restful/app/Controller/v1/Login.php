<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\AbstractController;
use Hyperf\Contract\SessionInterface;
use Hyperf\DB\DB;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;

/**
 * Class Login
 * @package App\Controller\v1
 */
class Login extends AbstractController
{
    /**
     * @Inject()
     * @var SessionInterface $session
     */
    private $session;
    protected $db;
    public function __construct()
    {
        $this->db = ApplicationContext::getContainer()->get(DB::class);
    }
    public function index()
    {
        return $this->response->raw('Hello Hyperf!');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $this->session->clear();
        $name = $this->request->post('name', 'default');
        $id = $this->db->execute("SELECT id FROM `users` WHERE name='{$name}'");
        $token = strtolower(md5($this->request->server('request_time') .''));

        $this->session->set('id', $id);
        $this->session->set('name', $name);
        $this->session->set('token', $token);
        $this->db->execute("UPDATE `users` set token='{$token}'");
        return $this->response->json(['status'=>0, 'message'=>'Hello login in!', 'token'=>$token]);
    }
}
