FROM php:8.2-apache
COPY superbot.php /var/www/html/
COPY php.ini /usr/local/etc/php/conf.d/

# Configuración crítica
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/php.ini

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
