<?php


namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Hyperf\HttpServer\Annotation\AutoController;

/** composer require guzzlehttp/guzzle
 * curl -v http://127.0.0.1:9501/guzzle_client/base
 * Class GuzzleClientController
 * @package App\Controller
 * @AutoController()
 */
class GuzzleClientController extends AbstractController
{
	public function base()
	{
		$client = new Client(['base_uri'=>'https://segmentfault.com', 'time_out'=>0.5]);
		$response = $client->request('get', '/');
		return 'ok? = '. $response->getStatusCode();
	}

	/**
	 * 并发抓取图片信息
	 */
	public function concurrent()
	{
		$client = new Client(['base_uri' => 'https://www.baidu.com/']);
		// Initiate each request but do not block
		$promises = [
			'image' => $client->getAsync('/image'),
			'png'   => $client->getAsync('/image/png'),
			'jpeg'  => $client->getAsync('/image/jpeg'),
			'webp'  => $client->getAsync('/image/webp')
		];
		// Wait on all of the requests to complete.
		$results = Promise\unwrap($promises);
		// You can access each result using the key provided to the unwrap
		// function.
		//print_r( $results['image']->getHeader('Content-Length') );
		//print_r( $results['png']->getHeaders() );
		return $results['jpeg']->getHeaders();
	}

	/**
	 * 上传文件，post数据
	 */
	public function loadFile()
	{
		$client = new Client();
		$body = [
			'others' => '其它参数',
			'multipart' =>
				[
					[
						'name' => 'data',
						'contents' => '{"field_1":"Test","field_2":"Test","field_3":"Test"}',
						'headers' =>
							[
								'Content-Type' => 'application/json',
							],
					],
					[
						'name' => 'file',
						'filename' => 'README.md',
						'Mime-Type' => 'application/text',
						'contents' => file_get_contents('./README.md'),
					]
				]
		];
		$res = $client->request('POST', 'http://127.0.0.1:9501/guzzle_client/write', $body);

		return $res->getBody();
	}

	public function write()
	{
		echo __CLASS__. ': '. __FUNCTION__.PHP_EOL;
		$files = $this->request->getUploadedFiles();
		//var_dump($files);
		foreach ($files as $f => $fileObj){
			//2者等效
			//var_dump($this->request->file($f), $fileObj);
			$file = $this->request->file($f);
			var_dump($file->getMimeType());
			$fileInfo = $file->toArray();
			var_dump($fileInfo);
			echo '以下是接收的文件内容： '. PHP_EOL;
			var_dump( file_get_contents($fileInfo['tmp_file']) );
			if(file_exists('/tmp/README.md.tmp')){
				echo '文件已存在： '. PHP_EOL;
			}else{
				$file->moveTo('/tmp/README.md.tmp'); //保存文件
				// 通过 isMoved(): bool 方法判断方法是否已移动
				if ($file->isMoved()) {
					echo $fileInfo['name'] .'文件已上传 '. PHP_EOL;
					unlink('/tmp/README.md.tmp');
					return $fileInfo;
				}
			}
		}
		return [];
	}
}