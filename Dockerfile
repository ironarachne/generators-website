FROM composer:1.8 as vendor

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM php:7.4-apache

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY .env.docker .env
COPY docker-vhost /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
