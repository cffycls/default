<?php


namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;

/**
 * <<11>> 异常捕获
 * @AutoController()
 */
class ExceptionController
{
	/**
	 * http://127.0.0.1:9501/exception/co
	 */
	public function co()
	{
		co(function (){
			while(true) {
				echo 1;
				sleep(1);
			}
		});
		return 'ok';
	}

	/**
	 * http://127.0.0.1:9501/exception/error
	 */
	public function error()
	{
		/**
		 * a. 响应级异常
		 * config/autoload/server.php:
		 *  servers.callbacks[
		 *      SwooleEvent::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest']
		 * ]
		 * 异常，被hyperf捕获，抛出 “500 Internal Server Error”，co-服务仍然可以正常请求
		 */
		throw new \RuntimeException('test');

		/**
		 * b. 系统级异常
		 * Hyperf\HttpServer\Server
		 *      的122行 [}catch (Throwable $throwable){] 下添加 throw $throwable;
		 *      会直接将错误发给系统-swoole，co-服务全部中断
		 *
		 * config/autoload/exceptions.php:
		 *  handler.http[
		 *      //App\Exception\Handler\AppExceptionHandler::class
		 * ]
		 * 依上面注释掉，co-服务不中断
		 */
	}
	/**
	 * c. 自定义异常响应
	 * App\Exception\Handler\TestExceptionHandler:
	 *
	 * 在配置文件 exceptions.php 中
	 *      handler.handler 添加类
	 */
}