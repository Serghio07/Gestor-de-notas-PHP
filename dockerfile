# Usar PHP 8.1 con Apache
FROM php:8.1-apache

# Instalar extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias
RUN composer install

# Exponer puerto 80
EXPOSE 80