FROM php:7.3-apache
RUN apt-get update && apt-get install -y nano libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
COPY . /var/www/html
COPY environment.conf /etc/apache2/conf-enabled/environment.conf