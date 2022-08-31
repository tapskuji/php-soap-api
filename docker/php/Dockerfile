FROM php:5.6-apache
# FROM php:5.4-apache
# FROM orsolin/php:5.3-apache

RUN apt-get update \
 && apt-get install -y vim git zlib1g-dev mariadb-client libzip-dev \
 && docker-php-ext-install zip mysqli pdo_mysql \
 && pecl install xdebug-2.2.7 \
 && docker-php-ext-enable xdebug \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer \
 && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

#COPY ./20-xdebug.ini /usr/local/etc/php/conf.d/
COPY docker/php/20-xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www
