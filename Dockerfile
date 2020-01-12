# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/compose/compose-file/#target

ARG PHP_VERSION=7.3
ARG NODE_VERSION=10
ARG NGINX_VERSION=1.16

FROM php:${PHP_VERSION}-fpm-alpine AS sylius_php

# persistent / runtime deps
RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
		mariadb-client \
	;

ARG APCU_VERSION=5.1.17
RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		coreutils \
		freetype-dev \
		icu-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		libtool \
		libwebp-dev \
		libzip-dev \
		mariadb-dev \
		zlib-dev \
	; \
	\
	docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include --with-webp-dir=/usr/include --with-freetype-dir=/usr/include/; \
	docker-php-ext-configure zip --with-libzip; \
	docker-php-ext-install -j$(nproc) \
		exif \
		gd \
		intl \
		pdo_mysql \
		zip \
	; \
	pecl install \
		apcu-${APCU_VERSION} \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
		apcu \
		opcache \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .sylius-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-cli.ini /usr/local/etc/php/php-cli.ini

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /application