FROM php:8.1-apache

# Install both mysqli and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copy all files into the container's web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Configure Apache to use index.php as default
RUN a2enmod dir
RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/conf-available/custom-dir.conf
RUN a2enconf custom-dir

EXPOSE 80
