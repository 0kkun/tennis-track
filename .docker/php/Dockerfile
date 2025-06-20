FROM php:8.1.8-fpm

COPY ./.docker/php/php.ini /usr/local/etc/php/

# for vite server
EXPOSE 5173

RUN set -x \
  && apt-get update \
  && apt-get install -y git libicu-dev libpng-dev libzip-dev libonig-dev wget zip unzip vim \
  && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
  && docker-php-ext-install bcmath exif gd intl pdo_mysql sockets zip opcache redis

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Composer install
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Install Node and npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
  && apt-get install -y nodejs

WORKDIR /var/www
ADD ./backend /var/www

RUN chown -R www-data:www-data /var/www/storage
