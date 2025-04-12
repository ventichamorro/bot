FROM php:8.2-apache
COPY superbot.php /var/www/html/
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "/var/www/html/superbot.php"]
