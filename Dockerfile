FROM php:7.4-apache
# FROM mysql:latest
# Install system dependencies
RUN apt-get update &&\
    apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nano

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip soap

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

RUN mkdir /var/www/logs/
COPY ./vh-local.conf /etc/apache2/sites-available/vh-local.conf
RUN a2enmod rewrite && a2enmod headers
RUN a2ensite vh-local
