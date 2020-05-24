<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Session\Handler;

return [
    //'handler' => Handler\FileHandler::class,
    'handler' => Handler\RedisHandler::class,
    'options' => [
        'connection' => 'default',
        'gc_maxlifetime' => 1200,
    ],
];