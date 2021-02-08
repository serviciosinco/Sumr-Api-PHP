FROM php:7.2-apache
#COPY ../src /var/www/html
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN pecl install imagick
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install mbstring

RUN docker-php-ext-enable mysqli
RUN docker-php-ext-enable imagick


RUN a2enmod rewrite
RUN apachectl restart

EXPOSE 80