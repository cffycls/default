restful-api格式的用户表查询，带身份验证
	
##### 1、项目初始化
```
composer create-project hyperf/hyperf-skelton restful
cd restful 
composer require hyperf/hyperf-devtool
```
##### 2、创建用户表
```
php bin/hyperf.php gen:migration create_users_table 
#填写 migrations/table.class 内容
php bin/hyperf.php migrate 
php bin/hyperf.php migrate:status
# 添加索引填写 migrations/xx_update_users_table.class 内容
php bin/hyperf.php migrate 
php bin/hyperf.php migrate:status
```
>[可用的字段定义方法](https://hyperf.wiki/#/zh-cn/db/migration?id=可用的字段定义方法)
composer require doctrine/dbal //根据报错，添加修改字段属性依赖
php bin/hyperf.php migrate:fresh 
php bin/hyperf.php migrate:rollback=1
php bin/hyperf.php migrate:status

###### bug: PHP Fatal error:  Uncaught Doctrine\DBAL\DBALException: Unknown database type enum requested, Doctrine\DBAL\Platforms\MySQL80Platform may not support it.
```
#### migrations/xx_update_users_table.php
    function up(){
	    Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
```
 
##### 3、创建控制器
```
# a.index/create/update/delete/select 注解路由，设置请求方法
php bin/hyperf.php gin:controller v1/Users #:文件路径 app/v1/Users.php
php bin/hyperf.php vendor:publish hyperf/db
#如果删除报错，执行 rm -rf runtime/*
./vendor/bin/init-proxy.sh
# 下载配置文件 php bin/hyperf.php vendor:publish hyperf/xx

# b.登录鉴权中间件
php bin/hyperf.php gen:middleware v1/Oauth
composer require hyperf/session #Oauth.php: process校验
    if ($this->session->has('id') && $this->session->get('token')){
        return $handler->handle($request);
    }
php bin/hyperf.php gen:controller v1/Login #login方法
    $this->session->clear();

    $this->session->set('id', mt_rand(1,999));
    $this->session->set('token', strtolower(md5($request->server('request_time'))));
    return $response->json(['status'=>0, 'message'=>'Hello login in!']);
    
# c.db:seed数据生成器
php bin/hyperf.php gen:seeder users #填写 seeders/users.php: run
php bin/hyperf.php db:seed
```
##### 4、配置路由
```
Router::addGroup('/v1', function (){
    Router::post('/login', 'App\Controller\v1\Login@login');
    Router::addGroup('/users', function (){
        Router::get('[/]', 'App\Controller\v1\Users@all');
        Router::get('/{id}', 'App\Controller\v1\Users@get');
        Router::post('[/]', 'App\Controller\v1\Users@create');
        Router::put('[/]', 'App\Controller\v1\Users@update');
        Router::delete('[/]', 'App\Controller\v1\Users@delete');

    }, ['middleware' => [\App\Middleware\v1\Oauth::class]]);
});

### 修改404页面
class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware
{
    //Hyperf\HttpServer\CoreMiddleware::class => App\Middleware\CoreMiddleware::class,    #dependencies.php覆盖原方法
    protected function handleNotFound(ServerRequestInterface $request)
    {
        // 重写路由找不到的处理逻辑
        return $this->response()->withStatus(404)->withBody(new SwooleStream('page not found...'));
    }
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request)
    {
        // 重写 HTTP 方法不允许的处理逻辑
        return $this->response()->withStatus(405)->withBody(new SwooleStream('operate not found...'));
    }
}
```
