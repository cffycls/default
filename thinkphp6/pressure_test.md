tp6 VS tp6+think-swoole 简单首页压力测试
====
```markdown
php think run -p 9601
配置 config/log.php: level: think\Log::ERROR

php think swoole start 
配置 config/swoole.php: 0.0.0.0:9602
```

tp6原始: 1px
```markdown
ab -r -c1000 -n100000 http://192.168.1.111:9601/
# 过程中，web端进入无响应状态
Requests per second:    560.38 [#/sec] (mean)
Time per request:       1784.502 [ms] (mean)
Time per request:       1.785 [ms] (mean, across all concurrent requests)
Transfer rate:          511.60 [Kbytes/sec] received

Requests per second:    539.26 [#/sec] (mean)
Time per request:       1854.390 [ms] (mean)
Time per request:       1.854 [ms] (mean, across all concurrent requests)
Transfer rate:          490.30 [Kbytes/sec] received
```

tp6-swoole版: 15px
```markdown
ab -r -c1000 -n100000 
config/config.php: 注释其它日志
    LogLevel::EMERGENCY,
    LogLevel::ERROR,
    LogLevel::WARNING,
#qps约提升到15倍 
Requests per second:    8351.52 [#/sec] (mean)
Time per request:       119.739 [ms] (mean)
Time per request:       0.120 [ms] (mean, across all concurrent requests)
Transfer rate:          7658.28 [Kbytes/sec] received

Requests per second:    7947.83 [#/sec] (mean)
Time per request:       125.821 [ms] (mean)
Time per request:       0.126 [ms] (mean, across all concurrent requests)
Transfer rate:          7288.10 [Kbytes/sec] received
```

hyperf版: 18px
```markdown
ab -r -c1000 -n100000 
#qps约提升到18倍
Requests per second:    10335.84 [#/sec] (mean)
Time per request:       96.751 [ms] (mean)
Time per request:       0.097 [ms] (mean, across all concurrent requests)
Transfer rate:          1867.32 [Kbytes/sec] received

Requests per second:    9915.22 [#/sec] (mean)
Time per request:       100.855 [ms] (mean)
Time per request:       0.101 [ms] (mean, across all concurrent requests)
Transfer rate:          1791.32 [Kbytes/sec] received
```