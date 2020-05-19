<?php

namespace App\Aspect;

use App\Annotation\FooAnnotation;
use App\Controller\FooController;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

/**
 * <<5.>> 切面编程模式（前--后 处理）
 * Class FooSpect
 * @Aspect
 */
class FooSpect extends AbstractAspect
{
	//定义切入类
    public $classes = [
        //SomeClass::class,
        //'App\Service\SomeClass::someMethod',
        //'App\Service\SomeClass::*Method',
        FooController::class,
        //FooController::class .'::'. 'show',
    ];

    //如果要切入注解类
    public $annotations = [
        FooAnnotation::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed|void
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        var_export(__FUNCTION__);
        $result = $proceedingJoinPoint->process();
        $foo = $proceedingJoinPoint->getAnnotationMetadata()->class[FooAnnotation::class];
        return [$result, 'has do something before & after', $result * $foo->calc];
    }
}