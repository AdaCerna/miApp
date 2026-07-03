FROM php:8.2-apache

# Habilitar mod_rewrite y extensión mysqli/pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

# Copiar código fuente
COPY src/ /var/www/html/

# Habilitar AllowOverride para el .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html
EXPOSE 80
