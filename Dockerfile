FROM php:8.3-cli
# Instalando las dependencias necesarias
RUN apt-get update && apt-get install -y git unzip libzip-dev libsqlite3-dev
# Ahora sobre extensiones PHP
RUN docker-php-ext-install pdo pdo_sqlite
# Extensión Redis
RUN pecl install redis && docker-php-ext-enable redis
# Copiando composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD php artisan serve --host=0.0.0.0 --port=8000
