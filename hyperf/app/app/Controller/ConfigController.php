<?php


namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * <<9.>> 配置引用
 * Class ConfigController
 * @AutoController()
 */
class ConfigController
{
    /**
     * @Inject()
     * @var ConfigInterface
     */
    private $config;

    function inject()
    {
        return $this->config->get('annotations');
    }

    function getValue()
    {
        return config('cache');
    }

}