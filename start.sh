#!/bin/bash
set -e

# 启动 Nginx
service nginx start

# 执行 PHP 命令
php start.php start