FROM php:8.2-apache

# Configuración esencial
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Habilita mod_rewrite
RUN a2enmod rewrite

# Configura el virtualhost
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos
COPY superbot.php /var/www/html/
COPY .htaccess /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod 644 /var/www/html/superbot.php

EXPOSE 80
CMD ["apache2-foreground"]