# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias y configura Apache
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Habilita mod_rewrite para URL amigables
RUN a2enmod rewrite

# Configura el virtualhost
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copia los archivos de la aplicación
COPY superbot.php /var/www/html/
COPY .htaccess /var/www/html/

# Establece permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Puerto expuesto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]