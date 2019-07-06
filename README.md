### prometheus grafana

~~~
https://github.com/Jimdo/prometheus_client_php
https://github.com/percona/grafana-dashboards
https://github.com/prometheus/mysqld_exporter
~~~

### 图表搭建

#### 请求量

~~~
sum(irate(http_server_requests_seconds_count{lang=\"php\",env=\"$env\",job=\"$job\",instance=~\"[[instance]]\"}[1m]))
~~~

#### 总体响应时间

~~~
sum(increase(http_server_requests_seconds_bucket{status_code=\"200\",lang=\"php\"}[1m]))by(le)
~~~

## 单个接口图表

#### 状态码

~~~
sum(http_server_requests_seconds_count{route=~\"[[route]]\",job=\"$job\",instance=~\"[[instance]]\",lang=\"php\"})by(status_code)
~~~

#### 响应延迟时间

~~~
sum(increase(http_server_requests_seconds_bucket{route=~\"[[route]]\",status_code=\"200\",lang=\"php\"}[1m]))by(le)
~~~

#### 吞吐量

~~~
sum(irate(http_server_requests_seconds_count{env=\"$env\",job=\"$job\",instance=~\"[[instance]]\",route=~\"[[route]]\"}[1m]))by(route)
~~~

### Apollo 

#### 文档

[链接](https://github.com/ctripcorp/apollo)

#### superviso配置

~~~
[program:apollo]
process_name=%(program_name)s
command=/usr/bin/php /var/www/html/artisan ue:apollo:sync
autostart=true
autorestart=true
user=www
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/apollo.log
~~~

#### crontab配置

~~~
*/1 * * * * /usr/bin/php /www/web/hsr/artisan ue:apollo:sync
~~~

### go rpc

[goRpc连接](https://github.com/missxiaolin/go-rpc)

### elk

[日志服务](https://github.com/missxiaolin/laravel-elk)

### 机器学习
[链接](https://github.com/missxiaolin/laravel-swoole-ml)
 
elk 安装 （mac）

~~~
brew install kibana
brew install elasticsearch
~~~

启动

~~~
brew services start kibana
brew services start elasticsearch
~~~
