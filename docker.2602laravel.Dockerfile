#FROM dockerhub.timeweb.cloud/library/node:latest AS node
FROM node:latest AS node
#FROM dockerhub.timeweb.cloud/library/php:8.2-fpm
FROM php:8.2-fpm

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Устанавливаем последнюю версию npm
RUN npm install -g npm@latest

ARG PHPGROUP
ARG PHPUSER
ARG FOLDER

ENV PHPGROUP=${PHPGROUP}
ENV PHPUSER=${PHPUSER}
ENV FOLDER=${FOLDER}

#WORKDIR ${FOLDER}

# Устанавливаем Chromium, chromedriver и все зависимости для запуска браузера
RUN apt-get update -y && \
    apt-get install -y --no-install-recommends \
        chromium \
        chromium-driver \
        libnss3 \
        libatk-bridge2.0-0 \
        libdrm2 \
        libxkbcommon0 \
        libgbm1 \
        libasound2 \
        libxcomposite1 \
        libxdamage1 \
        libxfixes3 \
        libxrandr2 \
        libpango-1.0-0 \
        libcairo2 \
        libatk1.0-0 \
        libcups2 \
        libdbus-1-3 \
        libexpat1 \
        libfontconfig1 \
        libgcc1 \
        libglib2.0-0 \
        libgtk-3-0 \
        libstdc++6 \
        wget \
        unzip \
        ca-certificates \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN ln -s /usr/bin/chromium /usr/bin/google-chrome \
    && ln -s /usr/bin/chromedriver /usr/local/bin/chromedriver

# Установка необходимых пакетов и расширений PHP
RUN apt-get update -y \
    && apt-get install -y git libzip-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-enable zip

# Установка расширения SOAP
# RUN docker-php-ext-install soap

# Install GD extension
RUN apt-get update \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
#
#RUN docker-php-ext-enable gd

# Увеличиваем лимиты загрузки файлов
#RUN echo "upload_max_filesize = 100M\npost_max_size = 100M" > /usr/local/etc/php/conf.d/uploads.ini

# # # Get latest Composer
#COPY --from=dockerhub.timeweb.cloud/library/composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Очистка кеша apt для уменьшения размера образа
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#RUN cd /home/2602test_laravel && chmod -R 0777 storage
#RUN cd ${FOLDER} && chmod -R 0777 storage

USER ${PHPUSER}
