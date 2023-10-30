# 设置基础镜像
FROM php:8.2-fpm

# 安装必要的软件包和依赖项
RUN apt-get update && apt-get install -y \
    nginx \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# 安装 PHP 扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip pdo_mysql
# 安装 pcntl 扩展
RUN docker-php-ext-install pcntl

# 安装 Redis 扩展
RUN pecl install redis-5.3.7 \
    && docker-php-ext-enable redis

# 安装 Xdebug 扩展
RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

# 安装 Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# 复制 Nginx 配置文件到容器
COPY ./dockerConfig/nginx/default.conf /etc/nginx/conf.d/default.conf

# 复制启动脚本到容器
COPY start.sh /start.sh

# 赋予启动脚本可执行权限
RUN chmod +x /start.sh

# 复制项目代码到容器
COPY . /var/www/html

# 设置文件和目录的权限
RUN chown -R www-data:www-data /var/www/html

# 在构建时执行composer install
RUN cd /var/www/html && composer install

# 启动 Nginx 和 PHP-FPM
CMD ["/start.sh"]
