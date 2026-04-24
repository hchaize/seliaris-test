FROM php:8.5-fpm

# install missing php dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
        libcurl4-openssl-dev libssl-dev \
        libzip-dev zip unzip zlib1g-dev \
        libicu-dev \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
    && docker-php-ext-install \
        zip \
        intl \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j$(nproc) gd \
    && apt-get clean

# copy php ini configuration
COPY ./docker/gateway/php/conf.d/php.ini /usr/local/etc/php/conf.d/docker-php.ini

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# copy xdebug ini configuration
COPY ./docker/gateway/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-xdebug.ini

# install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod a+x /usr/local/bin/composer

# install symfony binary
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv $HOME/.symfony5/bin/symfony /usr/local/bin/symfony \
    && chmod a+x /usr/local/bin/symfony

# install php cs fixer
RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v3.phar -o php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer \
    && chmod a+x /usr/local/bin/php-cs-fixer

# install git
RUN apt-get update && apt-get install -y --no-install-recommends git && apt-get clean

# set working directory
WORKDIR /www

COPY docker/gateway/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod a+x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["start"]
