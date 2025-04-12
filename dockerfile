FROM php:8.2-apache

# Copiar archivos
COPY superbot.php /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/

# Configuración PHP
RUN echo "max_execution_time = 120" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/php.ini

# Permisos
RUN chmod 644 /var/www/html/superbot.php

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "/var/www/html/superbot.php"]