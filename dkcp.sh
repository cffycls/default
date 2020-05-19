#!/bin/bash

# 2020.05.19 build
wget -O docker-compose "https://github.com/docker/compose/releases/download/1.26.0-rc4/docker-compose-Linux-x86_64"
mv docker-compose /usr/local/bin/docker-compose
chown cffycls:docker /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose


