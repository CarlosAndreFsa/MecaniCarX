FROM php:8.2-fpm

# Instala as dependências do sistema e as extensões PHP
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip gd

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Adiciona o código da sua aplicação
COPY . .

# Instala as dependências do projeto
RUN composer install --no-dev --optimize-autoloader

# Expõe a porta que o PHP-FPM vai usar
EXPOSE 9000

# Inicia o PHP-FPM
CMD ["php-fpm"]