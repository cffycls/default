<?php


namespace App\Controller;

use App\Service\UserService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class ListenController
 * @package App\Controller
 * @AutoController()
 */
class ListenController
{
	/**
	 * @Inject()
	 * @var UserService
	 */
	public $userService;

	public function test()
	{
		return $this->userService->register();
	}

}