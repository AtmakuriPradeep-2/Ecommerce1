# Use an official PHP image with Apache
FROM php:8.1-apache

# Install mysqli extension and other dependencies
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy all files into the container's web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
