<?php

namespace app\newapi\controller;

use think\Exception;
use think\facade\Request;
use think\facade\Cache;

/**
 * API鉴权验证
 */
class Oauth
{
    /**
     * accessToken存储前缀
     * @var string
     */
    public static $accessTokenPrefix = 'accessToken_';

    /**
     * 过期时间秒数
     * @var int
     */
    public static $expires = 7200;

    /**
     * 认证授权 通过用户信息和路由
     * @param Request $request
     * @return array
     */
    final function authenticate(Request $request)
    {
        return self::certification(self::getClient($request));
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return array $clientInfo
     */
    public static function getClient(Request $request)
    {
        //获取头部信息
        $authorization = $request->header('authentication');
        if (strlen($authorization) > 10) {
            $authorization = explode(" ", $authorization);  //authorization：USERID xxxx
            $authorizationInfo = explode(":", base64_decode($authorization[1]));
            $clientInfo['uid'] = $authorizationInfo[2];
            $clientInfo['appid'] = $authorizationInfo[0];
            $clientInfo['access_token'] = $authorizationInfo[1];

            return $clientInfo;
        } else {
            Newapi::returnMsg(401, 'Invalid authorization credentials');
        }
    }

    /**
     * 获取用户信息后 验证权限
     * @return mixed
     */
    public static function certification($data = [])
    {
        $getCacheAccessToken = Cache::get(self::$accessTokenPrefix . $data['access_token']);  //获取缓存access_token

        if (!$getCacheAccessToken) {
            Newapi::returnMsg(401, 'fail', "access_token不存在或为空");
        }
        if ($getCacheAccessToken['client']['appid'] !== $data['appid']) {

            Newapi::returnMsg(401, 'fail', "appid错误");  //appid与缓存中的appid不匹配
        }
        return $data;
    }

    /**
     * 生成签名
     * _字符开头的变量不参与签名
     * @param array $data
     * @param string $app_secret
     */
    public static function makeSign($data = [], $app_secret = '')
    {
        unset($data['version']);
        unset($data['sign']);
        return self::_getOrderMd5($data, $app_secret);
    }

    /**
     * 计算ORDER的MD5签名
     * @param array $params
     * @param string $app_secret
     */
    private static function _getOrderMd5($params = [], $app_secret = '')
    {
        ksort($params);
        $params['key'] = $app_secret;
        return strtolower(md5(urldecode(http_build_query($params))));
    }

}