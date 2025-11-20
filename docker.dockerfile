# Usar uma imagem base do PHP
FROM php:8.0-apache

# Copiar os arquivos do projeto para o diretório do Apache
COPY . /var/www/html/

# Instalar dependências do PHP (se necessário)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

# Habilitar mod_rewrite (caso precise de URLs amigáveis)
RUN a2enmod rewrite

# Expor a porta do servidor
EXPOSE 80
