<?php


namespace App\Service;


use App\Event\BeforeRegister;
use App\Event\UserRegistered;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;

class UserService
{
	/**
	 * @Inject()
	 * @var EventDispatcherInterface
	 */
	private $eventDispatcher; //引入事件监听分发类

	public function register()
	{
		//用户注册之前
		$beforeRegister = new BeforeRegister();
		$this->eventDispatcher->dispatch($beforeRegister);
		if($beforeRegister->shouldRegister){
			//注册用户
			$userId = rand(1,99999);
		}else{
			return false;
		}

		//注册成功后
		if($userId){
			$this->eventDispatcher->dispatch(new UserRegistered($userId));
		}
		return $userId;
	}

}