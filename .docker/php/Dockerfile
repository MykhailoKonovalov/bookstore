FROM php:8.3-fpm

RUN apt-get update && apt-get install --no-install-recommends -y \
    libicu-dev \
    libzip-dev \
    unzip \
    postgresql-client \
    libpq-dev \
    librabbitmq-dev \
    git

RUN docker-php-ext-install intl opcache pdo pdo_pgsql

RUN pecl install apcu && docker-php-ext-enable apcu
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install amqp && docker-php-ext-enable amqp
#RUN pecl install xdebug && docker-php-ext-enable xdebug \
#    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sL https://deb.nodesource.com/setup_21.x | bash -
RUN apt-get install -y nodejs
RUN npm install --global yarn

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN chmod 777 /usr/src --recursive

ARG UNAME=developer
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID -o $UNAME
RUN useradd -m -u $UID -g $GID -o -s /bin/ash $UNAME
USER $UNAME

WORKDIR /usr/src/app