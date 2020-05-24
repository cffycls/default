1、起源
====
a.从安装开始了解
----
[后盾人： LaraDock 新手使用教程](https://www.houdunren.com/topic/729) 

b.官方文档
----
[laradock 中文文档](https://laradock-docs.linganmin.cn/zh/getting-started/#%E8%A6%81%E6%B1%82)
[码云：Laradock](https://gitee.com/anviod/laradock)

2、环境构建
====
说明：本机原有少部分端口已经占用，按端口+10000对外端口配置。

a.docker-composer安装
----
```markdown
wget -O docker-compose "https://github.com/docker/compose/releases/download/1.26.0-rc4/docker-compose-Linux-x86_64"
mv docker-compose /usr/local/bin/docker-compose
chown cffycls:docker /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
```
b.环境构建
----
```markdown
修改 .env 的php、MySQL版本
### 目录结构
hdcms
houdunren
laradock *[该文件夹为下面的根操作路径]
###
docker-compose up -d nginx php-fpm mysql workspace
漫长...
```
workspace很卡，换源fix，重试:
```markdown
### curl: (7) Failed to connect to raw.githubusercontent.com port 443: Connection refused
1) 百度上面： https://www.jianshu.com/p/c2e829027b0a
cat /etc/hosts && echo -e "#githubusercontent\n199.232.68.133  githubusercontent.com\n">>/etc/hosts
再次执行依旧报错
2) 依据错误情况，备份并修改 workplace/Dockerfile:
【这里采用本地下载，修改Dockerfile手动添加文件】 
### 解决：
wget -O workplace/install.sh https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh
# workplace/Dockerfile 修改
添加
COPY --chown=laradock:laradock ./install.sh /work_install.sh
修改
    #curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
    ls $NVM_DIR -alh && ls -alh /work_install.sh && id && /work_install.sh \
```
workspace插件比较多。
##### nodejs、github换源：
```markdown
## workplace/Dockerfile 修改
添加
echo -e "\n151.101.185.194  github.global-ssl.fastly.net \n192.30.253.112 github.com\n" >> /etc/hosts \
## .env 修改:
WORKSPACE_COMPOSER_REPO_PACKAGIST=https://mirrors.aliyun.com/composer/
WORKSPACE_NVM_NODEJS_ORG_MIRROR=https://npm.taobao.org/mirrors/node
WORKSPACE_NPM_REGISTRY=https://registry.npm.taobao.org
```
##### .env冲突端口修改
```markdown
### 自定义端口映射，使用域名访问、不加端口时，需要配合本机80反向代理
HTTP_PORT=80\n ==> HTTP_PORT=10080\n phpmyadmin
HTTP_PORT=8080\n ==> HTTP_PORT=18080\n nginx
HTTPS_PORT=443\n ==> HTTPS_PORT=10443\n nginx
VARNISH_BACKEND_PORT=81 ==> VARNISH_BACKEND_PORT=10081 nginx
PORT==3306\n ==> PORT=1=3306\n mysql
PORT=6379\n ==> PORT=16379\n redis
docker system prune 清理缓存尝试
```

c. 构建结果
----
```markdown
### docker-compose ps

laradock_docker-in-docker_1   dockerd-entrypoint.sh            Up      2375/tcp, 2376/tcp                                                                                                   
laradock_mysql_1              docker-entrypoint.sh mysqld      Up      0.0.0.0:13306->3306/tcp, 33060/tcp                                                                                   
laradock_nginx_1              /bin/bash /opt/startup.sh        Up      0.0.0.0:10443->443/tcp, 0.0.0.0:10080->80/tcp, 0.0.0.0:10081->81/tcp                                                 
laradock_php-fpm_1            docker-php-entrypoint php-fpm    Up      9000/tcp                                                                                                             
laradock_phpmyadmin_1         /docker-entrypoint.sh apac ...   Up      0.0.0.0:18081->80/tcp                                                                                                
laradock_redis_1              docker-entrypoint.sh redis ...   Up      0.0.0.0:16379->6379/tcp                                                                                              
laradock_workspace_1          /sbin/my_init                    Up      0.0.0.0:2222->22/tcp, 0.0.0.0:3000->3000/tcp, 0.0.0.0:3001->3001/tcp, 0.0.0.0:8001->8000/tcp, 0.0.0.0:18080->8080/tcp
```
3、使用测试
====
a.打开 phpmyadmin 
----
```markdown
http://127.0.0.1:18081/    laradock_phpmyadmin    OK
#登录 find / -name '*.conf' |xargs grep -rn ServerName
### php_network_getaddresses: getaddrinfo failed: Name or service not known
Dockerfile:
sed -i "s/\$cfg\['Servers'\]\[\$i\]\['host'\] = 'localhost';/\$cfg\['Servers'\]\[\$i\]\['host'\] = '127.0.0.1';/"  /var/www/html/config.sample.inc.php
echo "ServerName localhost:80" >> /etc/apache2/sites-enabled/000-default.conf
#echo "ServerName 127.0.0.1:80" >> /etc/apache2/sites-enabled/000-default.conf

docker-compose build phpmyadmin 
```
##### 登录
```markdown
### Failed to set session cookie. Maybe you are using HTTP instead of HTTPS to access phpMyAdmin.
host: mysql
root: root
password: root 
```
phpmyadmin建表操作正常。

b.打开 项目初始页面
----
项目数据库配置
```markdown
### .env
DB_HOST=mysql
DB_HOST=redis

#### laradock/nginx/sites/xx.conf 
server_name houdunren.test;
root /var/www/hdcms/public;

docker-compose restart nginx
```
注意配置hosts时端口设置会无效
```markdown
### deepin开发主机操作
#添加hosts，准备浏览测试（这里127.0.0.1:10080端口自动忽略）
cat >> /etc/hosts <<EOF
127.0.0.1  hdcms.test
127.0.0.1  houdunren.test
EOF
cat /etc/hosts


    server {
        listen 80;
        server_name  *.test *.api;
        location / {
            #本地开发时，使用主机名称访问的 80的nginx转发到docker的10080nginx 
            proxy_set_header Host               $host;
            proxy_set_header X-Real-IP          $remote_addr;
            proxy_set_header X-Forwarded-For    $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto  $scheme;
            proxy_set_header X-Forwarded-Host   $host;
            proxy_set_header X-Forwarded-Port   $server_port;
            proxy_pass    http://127.0.0.1:10080;
        }
    }
```

##### 浏览 hdcms.test、houdunren.test 显示laravel首页

4、restful应用测试
====



```markdown

```