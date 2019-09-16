FROM php:7-cli-alpine

RUN apk add \
	ncurses \
	gnupg \
	git \
	$PHPIZE_DEPS

RUN pecl install ast \
    && docker-php-ext-install bcmath \
	&& docker-php-ext-enable ast bcmath

COPY . /project-euler
WORKDIR /project-euler

RUN adduser -S euler \
 && chown -R euler /project-euler

USER euler

RUN php ./tools/composer.phar install --no-dev --optimize-autoloader

ENTRYPOINT ["bin/project-euler"]
