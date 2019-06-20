FROM php:7.3.6-apache-stretch

RUN cat /etc/apt/preferences.d/no-debian-php
RUN rm /etc/apt/preferences.d/no-debian-php
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update

RUN apt -y install ca-certificates apt-transport-https wget gnupg2
RUN wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add -
RUN echo "deb https://packages.sury.org/php/ stretch main" | tee /etc/apt/sources.list.d/php.list
RUN cat /etc/apt/sources.list.d/php.list
RUN apt -y update

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apt -y install zip unzip

RUN apt -y install php7.3-zip

RUN dpkg -s php7.3-zip |  grep Status

RUN cat /usr/local/etc/php/conf.d/docker-php-ext-sodium.ini

RUN apt-get install -y zlib1g-dev libzip-dev

RUN docker-php-ext-install zip

RUN cat /usr/local/etc/php/conf.d/docker-php-ext-sodium.ini

RUN composer global require "laravel/lumen-installer"

RUN cat /etc/apache2/apache2.conf

RUN ls /etc/apache2/sites-available

RUN cat /etc/apache2/sites-available/000-default.conf

RUN pwd

RUN ls /var/www/html

COPY . .

COPY apache/000-default.conf /etc/apache2/sites-available/

RUN cat /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN ls /var/www/html


RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev
RUN apt-get -y install libzip-dev
RUN wget -O- http://packages.couchbase.com/ubuntu/couchbase.key | apt-key add - 
RUN wget -O/etc/apt/sources.list.d/couchbase.list \
    http://packages.couchbase.com/ubuntu/couchbase-ubuntu1204.list
RUN apt-get update

RUN apt-get -y install lsb-release
RUN docker-php-ext-install zip
RUN composer self-update
RUN wget http://packages.couchbase.com/releases/couchbase-release/couchbase-release-1.0-6-amd64.deb
RUN dpkg -i couchbase-release-1.0-6-amd64.deb
RUN apt-get update
RUN apt-get install libcouchbase-dev build-essential zlib1g-dev
RUN pecl install couchbase
RUN echo "extension=couchbase.so" | tee /usr/local/etc/php/php.ini > /dev/null

RUN composer install -n --prefer-dist
RUN cp -fr ./.circleci/HybridRelations.php ./vendor/developermarshak/laravel-couchbase/src/Mpociot/Couchbase/Eloquent/HybridRelations.php
RUN  cp -fr ./.circleci/Model.php ./vendor/developermarshak/laravel-couchbase/src/Mpociot/Couchbase/Eloquent/Model.php

ARG db_connection=default_value
ENV DB_CONNECTION=$db_connection
ARG db_host=default_value
ENV DB_HOST=$db_host
ARG db_port=default_value
ENV DB_PORT=$db_port
ARG db_database=default_value
ENV DB_DATABASE=$db_database
ARG db_username=default_value
ENV DB_USERNAME=$db_username
ARG db_password=default_value
ENV DB_PASSWORD=$db_password
ARG cache_driver=default_value
ENV CACHE_DRIVER=$cache_driver
ARG queue_connection=default_value
ENV QUEUE_CONNECTION=$queue_connection
ARG jwt_secret=default_value
ENV JWT_SECRET=$jwt_secret
ARG frontend_url=default_value
ENV FRONTEND_URL=$frontend_url

RUN composer update --no-scripts

RUN ./vendor/bin/phpunit --debug
