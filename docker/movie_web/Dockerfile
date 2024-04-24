FROM php:8.1.18-apache

RUN apt-get update

# install required packages
RUN apt-get install -y \
    git \
    cron \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libyaml-dev \
    librabbitmq-dev \
    libonig-dev \
    unzip \
    nano

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# install php extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    calendar \
    zip \
    xml \
    gd \
    intl \
    exif \
    soap \
    bcmath \
    opcache \
    gd

RUN docker-php-ext-configure opcache --enable-opcache

# amqp for rabbit
RUN docker-php-source extract \
    && git clone --branch v1.11.0 --depth 1 https://github.com/php-amqp/php-amqp.git /usr/src/php/ext/amqp \
    && cd /usr/src/php/ext/amqp && git submodule update --init \
    && docker-php-ext-install amqp

# redis
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis
# pcntl
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl
# composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
# xdebug
# RUN pecl install xdebug && docker-php-ext-enable xdebug

ENV TZ=Europe/Warsaw
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/app/

# APACHE PART
# document root update
ENV APACHE_DOCUMENT_ROOT /var/www/app/public
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod headers
RUN apache2ctl -M
RUN mkdir -p /var/imported/ssl/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Entry script to run cron and apache2
COPY docker/movie_web/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["bash", "/var/www/app/docker/movie_web/entrypoint.sh"]
