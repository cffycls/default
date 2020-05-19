#laradock使用总结


1、起源
====
a.了解
----
[后盾人： LaraDock 新手使用教程](https://www.houdunren.com/topic/729) 

b.官方文档
----
[laradock 中文文档](https://laradock-docs.linganmin.cn/zh/getting-started/#%E8%A6%81%E6%B1%82)

2、使用
====
a.docker-composer安装
----
```markdown
#!/bin/bash

# 2020.05.19 build
wget -O docker-compose "https://github.com/docker/compose/releases/download/1.26.0-rc4/docker-compose-Linux-x86_64"
mv docker-compose /usr/local/bin/docker-compose
chown cffycls:docker /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
```
b.环境构建
----
```markdown
修改 .env 的php、MySQL版本

docker-compose up -d nginx php-fpm mysql workspace
漫长...
```
fix:
```markdown
curl: (7) Failed to connect to raw.githubusercontent.com port 443: Connection refused
1) 百度上面： https://www.jianshu.com/p/c2e829027b0a
cat /etc/hosts && echo -e "#githubusercontent\n199.232.68.133  githubusercontent.com\n">>/etc/hosts
再次执行依旧报错
2) 依据错误情况，备份并修改 workplace/Dockerfile:
【本地下载】 wget -O workplace/install.sh https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh
添加
COPY --chown=laradock:laradock ./install.sh /work_install.sh
修改
    #curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
    ls $NVM_DIR -alh && ls -alh /work_install.sh && id && /work_install.sh \
```
下载提速
```markdown
添加
echo -e "\n151.101.185.194  github.global-ssl.fastly.net \n192.30.253.112 github.com\n" >> /etc/hosts \
修改.env:
WORKSPACE_COMPOSER_REPO_PACKAGIST=https://mirrors.aliyun.com/composer/
WORKSPACE_NVM_NODEJS_ORG_MIRROR=https://npm.taobao.org/mirrors/node
WORKSPACE_NPM_REGISTRY=https://registry.npm.taobao.org
```
