FROM php:7-cli-alpine

RUN apk add \
	ncurses \
	gnupg \
	git \
	$PHPIZE_DEPS

RUN pecl install ast \
	&& docker-php-ext-enable ast
