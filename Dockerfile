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

FROM node:12.10 as frontend

RUN mkdir -p /app/public

COPY package.json webpack.mix.js yarn.lock /app/
COPY resources/assets/ /app/resources/assets/

WORKDIR /app

RUN yarn install && yarn production

FROM php:7.3-apache-stretch

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /app/public/js/ /var/www/html/public/js/
COPY --from=frontend /app/public/css/ /var/www/html/public/css/
COPY --from=frontend /app/mix-manifest.json /var/www/html/mix-manifest.json
COPY .env.docker-prod .env
COPY docker-vhost /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
