FROM php:7.4-cli
WORKDIR /var/www/html
COPY . .
COPY ./composer.json ./
RUN apt-get update
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN apt-get -y install git
RUN chown www-data:www-data * -R
RUN docker-php-ext-install pdo pdo_mysql
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN composer install