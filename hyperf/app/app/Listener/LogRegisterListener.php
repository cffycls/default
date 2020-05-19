<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\BeforeRegister;
use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener(priority=9)
 */
class LogRegisterListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
	        BeforeRegister::class,
        	UserRegistered::class,
        ];
    }

    public function process(object $event)
    {
    	if ($event instanceof BeforeRegister){
		    echo '注册身份验证'. ($event->shouldRegister ? '通过' : '失败') .PHP_EOL;
	    }elseif($event instanceof UserRegistered){
		    echo '发送短信,E-mail给'. $event->userId .PHP_EOL;
	    }
    	/**请求输出：
	     *
	     * 注册身份验证失败
	     * 注册身份验证通过
	     * 发送短信,E-mail给82504
	     * 发送短信给82504
	     * 发送E-mail给82504
	     */
    }
}
