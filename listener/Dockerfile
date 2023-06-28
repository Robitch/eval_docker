FROM composer:2.5 as composer

WORKDIR /app

COPY composer.json /app/
COPY composer.lock /app/
RUN composer install --ignore-platform-req=ext-sockets


FROM php:8

RUN docker-php-ext-install sockets

COPY listener.php /app/

COPY --from=composer /app/vendor /app/vendor

WORKDIR /app

CMD [ "php", "listener.php" ]
