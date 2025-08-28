FROM php:8.1-apache

# Instalar dependencias necesarias para intl
RUN apt-get update && apt-get install -y libicu-dev

# Instalar extensiones PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql intl

# Habilitar mysqli e intl
RUN docker-php-ext-enable mysqli intl

WORKDIR /var/www/html/apprueba_app/public

CMD ["apache2-foreground"]