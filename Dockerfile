FROM php:7.4-cli
COPY . /usr/src/myapp
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /usr/src/myapp
