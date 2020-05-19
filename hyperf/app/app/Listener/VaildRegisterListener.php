<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\BeforeRegister;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
class VaildRegisterListener implements ListenerInterface
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
	        BeforeRegister::class
        ];
    }

	/**
	 * @param BeforeRegister $event
	 */
    public function process(object $event)
    {
    	$event->shouldRegister = (bool) rand(0,2);
	    echo '注册身份验证'. ($event->shouldRegister ? '通过' : '失败') .PHP_EOL;
    }
}
