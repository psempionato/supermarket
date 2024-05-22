# Imagem oficial do PHP 8.1
FROM php:8.1-cli

# Define o diretório de trabalho
WORKDIR /var/www/html

# Dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs\
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Set the repository permissions
RUN groupadd -fg 1000 www \
    && useradd -p teste -ms /bin/bash -g 1000 -u 1000 www

USER www

# Copia o código da aplicação para o container
COPY . /var/www/html

# Expondo a 8000 para servir aplicativos PHP
EXPOSE 8080

# Inicia o servidor PHP
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]