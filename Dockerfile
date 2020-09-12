FROM php:7.4-fpm

ARG TZ=Asia/Tokyo
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN docker-php-ext-install pdo pdo_mysql

# composer install
COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 9000
