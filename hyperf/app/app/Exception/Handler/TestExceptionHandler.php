<?php


namespace App\Exception\Handler;


use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class TestExceptionHandler extends ExceptionHandler
{

	/**
	 * @inheritDoc
	 */
	public function handle(Throwable $throwable, ResponseInterface $response)
	{
		//最终--异常处理
		$this->stopPropagation();
		return $response->withStatus(501)->withBody(new SwooleStream("this is test exception case".PHP_EOL));
	}

	/**
	 * @inheritDoc
	 */
	public function isValid(Throwable $throwable): bool
	{
		return $throwable instanceof \RuntimeException;
	}
}