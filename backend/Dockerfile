# Aqui dizemos que utilizaremos como base do container a imagem docker do PHP 8.3
FROM php:8.3-fpm 

# Aqui setamos o workdir que será a pasta utilizada dentro do container (essa pasta ai é a padrão).
WORKDIR /var/www/html

# Aqui Instalamos a extensão do PHP para PostgreSQL e as demais extensões necessárias.
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# O comando COPY normalmente trabalha da maquina para o WORKDIR, porém como colocamos o --from, ele ignora a maquina
# buscamos da imagem do composer 'composer:latest'
# dentro de '/usr/bin/composer' da imagem colamos em '/usr/bin/composer' no WORKDIR
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer