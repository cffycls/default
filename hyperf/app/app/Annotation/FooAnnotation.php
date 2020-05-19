<?php
namespace App\Annotation; //bug 注意大小写 *2

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * <<4.>> 自定义注解
 * @Annotation
 * @Target({"CLASS","METHOD","PROPERTY"})
 */
class FooAnnotation extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $bar;
    /**
     * @var int
     */
    public $calc;

}