FROM php:8.2-fpm-alpine

ENV TZ=Europe/Prague

# Install dependencies
RUN set -eux \
    && apk update \
    && apk add --no-cache \
        unzip \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# https://github.com/mlocati/docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && sync  \
    && install-php-extensions \
        intl \
        zip \
        pdo \
        pdo_mysql \
        xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html/

CMD ["php-fpm"]

EXPOSE 9000

