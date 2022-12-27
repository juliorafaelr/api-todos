FROM php:8.1-fpm

SHELL ["/bin/bash", "-c"]

# Set working directory
WORKDIR /var/www

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libzip-dev zlib1g-dev libicu-dev libpng-dev libpq-dev zip unzip postgresql

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath intl gd pdo pdo_pgsql pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY composer.* ./

RUN composer install --no-scripts --no-plugins --no-interaction --optimize-autoloader --prefer-dist

# Copy existing application directory contents
COPY . /var/www

RUN mkdir -p ./storage/framework/cache/data && \
    mkdir -p ./storage/framework/sessions && \
    mkdir -p ./storage/framework/views

# Copy existing application directory permissions
RUN chown -R 33:33 /var/www

#RUN chmod -R 777 ./storage
USER 33

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
