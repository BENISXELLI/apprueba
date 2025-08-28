FROM php:8.1-apache

# Instalar dependencias y extensiones PHP necesarias, incluyendo nano y vim
RUN apt-get update && \
    apt-get install -y libicu-dev nano vim git unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql intl && \
    docker-php-ext-enable mysqli intl && \
    a2enmod rewrite && \
    rm -rf /var/lib/apt/lists/*

# Copiar proyecto
COPY . /var/www/html/apprueba_app

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html/apprueba_app \
    && chmod -R 755 /var/www/html/apprueba_app

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/apprueba_app/public|' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html/apprueba_app/

EXPOSE 80

CMD ["bash", "-c", "php spark migrate && apache2-foreground"]