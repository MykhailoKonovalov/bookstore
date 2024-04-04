FROM php:8.3-fpm

RUN apt-get update
RUN apt-get install --no-install-recommends -y libicu-dev
RUN apt-get install --no-install-recommends -y libzip-dev
RUN apt-get install --no-install-recommends -y unzip
RUN apt-get install --no-install-recommends -y postgresql-client
RUN apt-get install --no-install-recommends -y libpq-dev

RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo pdo_pgsql

RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app

RUN chmod 777 /usr/src/app --recursive