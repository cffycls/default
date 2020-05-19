<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener(priority=2)
 */
class SendSmsListener implements ListenerInterface
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
        	UserRegistered::class
        ];
    }

	/**
	 * @param UserRegistered $event
	 */
    public function process(object $event)
    {
    	echo '发送短信给'. $event->userId .PHP_EOL;
    }
}
