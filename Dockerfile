FROM php:8.1-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod dir
RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/conf-available/custom-dir.conf
RUN a2enconf custom-dir

EXPOSE 80
