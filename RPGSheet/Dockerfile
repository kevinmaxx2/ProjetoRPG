
FROM php:8.2

RUN apt-get update -y && apt-get install -y \
    libpq-dev \
    libonig-dev \
    openssl \
    zip \
    unzip \
    git && \
    docker-php-ext-install pdo mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    /usr/local/bin/composer --version
RUN ls -l /usr/local/bin/composer
# Set the working directory
WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8800

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8800"]
