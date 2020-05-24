<?php
/**
 * Created by PhpStorm.
 * User: cffyc
 * Date: 2019/7/1
 * Time: 13:08
 */

session_start();

$serverInfo = [
	'------'=>'------',
	'gethostname: 主机名'=>gethostname(),
	'gethostbyname: 主机ip'=>gethostbyname(gethostname()),
	'REQUEST_TIME'=>date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']),
	'HTTP_COOKIE'=>$_SERVER['HTTP_COOKIE'],
	'HTTP_HOST'=>$_SERVER['HTTP_HOST'],
	'SERVER_SOFTWARE'=>$_SERVER['SERVER_SOFTWARE'],
	'SERVER_ADDR'=>$_SERVER['SERVER_ADDR'],
	'SERVER_PORT'=>$_SERVER['SERVER_PORT'],
	'REMOTE_ADDR'=>$_SERVER['REMOTE_ADDR'],
	'REMOTE_PORT'=>$_SERVER['REMOTE_PORT'],
	'HTTP_X_REAL_IP'=>$_SERVER['HTTP_X_REAL_IP'],
	'HTTP_X_FORWARDED_FOR'=>$_SERVER['HTTP_X_FORWARDED_FOR'],
	//'$_SERVER'=>$_SERVER,
];
echo '<pre>';
$data = array_merge_recursive(['session_id'=>session_id()], $serverInfo);
print_r($data);

$path = ini_get("session.save_path");
$sess = parse_url($path);
if(is_array($sess)){
    print_r("session.save_path: " .$sess['host'] .":" .$sess['port'] .PHP_EOL);
}else{
    print_r("session.save_path: " .session_save_path() .PHP_EOL);
}


