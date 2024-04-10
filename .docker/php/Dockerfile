FROM php:8.3-fpm

RUN apt-get update
RUN apt-get install --no-install-recommends -y libicu-dev
RUN apt-get install --no-install-recommends -y libzip-dev
RUN apt-get install --no-install-recommends -y unzip
RUN apt-get install --no-install-recommends -y postgresql-client
RUN apt-get install --no-install-recommends -y libpq-dev
RUN apt-get install --no-install-recommends -y librabbitmq-dev
RUN apt-get install --no-install-recommends -y git

RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql

RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install amqp && docker-php-ext-enable amqp
RUN pecl install xdebug && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN chmod 777 /var --recursive

ARG UNAME=developer
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID -o $UNAME
RUN useradd -m -u $UID -g $GID -o -s /bin/ash $UNAME
USER $UNAME

WORKDIR /var/www/html