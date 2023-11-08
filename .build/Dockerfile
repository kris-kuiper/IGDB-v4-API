FROM php:8.2.7-apache-buster

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libmcrypt-dev \
    libicu-dev \
    libxml2-dev \
    libxslt-dev \
    libzip-dev \
    libwebp-dev \
    libxpm-dev \
    librabbitmq-dev


RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-webp --with-jpeg --with-xpm --with-freetype
RUN docker-php-ext-install -j$(nproc) gd iconv gettext intl bcmath soap xsl sockets


# Apache
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=NL/ST=Arnhem/L=Arnhem/O=Security/OU=Development/CN=sfire.nl"

ENV APACHE_DOCUMENT_ROOT '/var/www'

RUN a2enmod rewrite
RUN a2enmod headers expires

# Configure the new VirtualHost
RUN { \
        echo '<VirtualHost *:80>'; \
        echo "    DocumentRoot $APACHE_DOCUMENT_ROOT"; \
        echo '</VirtualHost>'; \
    } > /etc/apache2/sites-available/000-default.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /var/www
EXPOSE 80
