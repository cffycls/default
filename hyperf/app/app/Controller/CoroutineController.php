<?php


namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * <<7-8>> 协程
 * Class CoroutineController
 * @AutoController()
 */
class CoroutineController
{
    /**
     * @Inject()
     * @var ClientFactory
     */
    private $clientFactory;

    public function sleep(RequestInterface $request)
    {
        $sec = $request->query('second',1);
        sleep($sec);
        return $sec;
    }

    public function test()
    {
        $time = (float) time() + floatval(microtime());
        $client = $this->clientFactory->create();
        $client->get('127.0.0.1:9501/coroutine/sleep?second=2');

        $client = $this->clientFactory->create();
        $client->get('127.0.0.1:9501/coroutine/sleep?second=2');

        return __FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4);
    }

    /** Channel 通道
     * 队列
     * @return array
     */
    public function testCo()
    {
        $time = (float) time() + floatval(microtime());

        $channel = new \Swoole\Coroutine\Channel();
        co(function () use ($channel) {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=2');
            $channel->push('123');
        });
        co(function () use ($channel) {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=2');
            $channel->push('123');
        });
        $result[] = $channel->pop();
        $result[] = $channel->pop();

        return [__FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4), $result];
    }

    /** WaitGroup 特性
     * 组等待
     * @return array
     */
    public function testCo2()
    {
        $time = (float) time() + floatval(microtime());

        $group = new \Swoole\Coroutine\WaitGroup();
        $group->add(2);
        $result = [];
        co(function () use ($group, &$result) {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=1');
            $result[] = '123';
            $group->done();
        });
        co(function () use ($group, &$result) {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=2');
            $result[] = '321';
            $group->done();
        });
        $group->wait();

        return [__FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4), $result];
    }

    /** Parallel 特性
     * 便捷版 WaitGroup
     * @return array
     */
    public function testCo3()
    {
        $time = (float) time() + floatval(microtime());

        $parallel = new \Hyperf\Utils\Parallel(); //2
        $parallel->add(function () {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=1');
            return '123: '. \Hyperf\Utils\Coroutine::id();
        });
        $parallel->add(function () {
            $client = $this->clientFactory->create();
            $client->get('127.0.0.1:9501/coroutine/sleep?second=2');
            return '321: '. \Hyperf\Utils\Coroutine::id();
        });
        $result = $parallel->wait();

        return [__FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4), $result];
    }
    public function testCo33()
    {
        $time = (float) time() + floatval(microtime());

        $result = parallel([
            function () {
                $client = $this->clientFactory->create();
                $client->get('127.0.0.1:9501/coroutine/sleep?second=1');
                return '123: '. \Hyperf\Utils\Coroutine::id();
            },
            function () {
                $client = $this->clientFactory->create();
                $client->get('127.0.0.1:9501/coroutine/sleep?second=2');
                return '321: '. \Hyperf\Utils\Coroutine::id();
            }
        ]);

        return [__FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4), $result];
    }

    /** Concurrent 协程运行控制
     * 高级控制版 WaitGroup
     * @return array
     */
    public function testCo9()
    {
        $time = (float) time() + floatval(microtime());

        $concurrent = new \Hyperf\Utils\Coroutine\Concurrent(5);
        $result = [];

        for ($i = 0; $i < 15; ++$i) {
            $concurrent->create(function () use ($i, &$result) {
                $client = $this->clientFactory->create();
                $client->get('127.0.0.1:9501/coroutine/sleep?second='. ($i%5+1));
                $result[] = [$i. ': '. \Hyperf\Utils\Coroutine::id()];
                return 1;
            });
        }
        //由于并行机制 句柄移交的原因， 这里result结果输出数是 15-5=12 个

        return [__FUNCTION__.' ok: '. round((float) time() + floatval(microtime()) - $time,4), $result];
    }
}