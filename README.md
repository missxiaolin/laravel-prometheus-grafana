### prometheus grafana

~~~
https://github.com/Jimdo/prometheus_client_php
https://github.com/percona/grafana-dashboards
https://github.com/prometheus/mysqld_exporter
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
