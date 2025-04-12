# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copia los archivos esenciales
COPY superbot.php /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/

# Configuración de PHP (ajustes críticos)
RUN echo "max_execution_time = 120" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/php.ini

# Permisos y puerto
RUN chmod 644 /var/www/html/superbot.php
EXPOSE 80

# Comando de inicio (¡Asegúrate que apunte al archivo correcto!)
CMD ["php", "-S", "0.0.0.0:80", "/var/www/html/superbot.php"]