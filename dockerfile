FROM php:8.2-apache

# Instalar dependencias para debugging
RUN apt-get update && apt-get install -y \
    nano \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Copiar archivos
COPY superbot.php /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/

# Permisos de escritura para logs
RUN touch /var/www/html/debug.log && \
    touch /var/www/html/error.log && \
    chmod 666 /var/www/html/*.log

# Configuración PHP
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/php.ini && \
    echo "log_errors = On" >> /usr/local/etc/php/conf.d/php.ini

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]