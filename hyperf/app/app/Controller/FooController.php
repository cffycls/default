<?php

namespace App\Controller;

use App\Annotation\FooAnnotation;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 * @FooAnnotation(bar="123", calc=11)
 */
class FooController
{
    public function index()
    {
        /**
         * 检查注释类的引用 2020.01.09 bug
         *
         * AnnotationCollector => getClassByAnnotation
         * //var_dump($annotation, static::$container['App\\Controller\\FooController']['_c']);
         */

        var_dump(FooAnnotation::class, AnnotationCollector::getClassByAnnotation(FooAnnotation::class));
        return __CLASS__.': '.__FUNCTION__.'_'.__LINE__;
    }

    public function show()
    {
        return 233;
    }
}