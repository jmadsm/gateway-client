FROM php:8.2-apache

ARG UID=1000
RUN useradd -G www-data -u ${UID} app

RUN apt-get update && apt-get install -y zip libzip-dev

RUN docker-php-ext-install \
    zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.log=/var/www/html/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY apache-vhost.conf /etc/apache2/sites-available/000-laravel.conf
RUN a2enmod rewrite headers
RUN a2dissite *
RUN a2ensite 000-laravel.conf

USER app

VOLUME [ "/var/www/html" ]
EXPOSE 80
CMD [ "apache2-foreground" ]
