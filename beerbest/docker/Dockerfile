FROM serversideup/php:8.4-fpm-nginx-alpine

USER root

ARG USER_ID=1000
ARG GROUP_ID=1000

COPY --from=ghcr.io/php/pie:bin /pie /usr/bin/pie

RUN apk --update --no-cache add autoconf \
    build-base linux-headers \
    curl-dev openssl-dev

RUN pie install mongodb/mongodb-extension
RUN pie install xdebug/xdebug

RUN apk del autoconf build-base linux-headers

RUN composer self-update

RUN docker-php-serversideup-set-id www-data ${USER_ID}:${GROUP_ID} \
  && docker-php-serversideup-set-file-permissions --owner ${USER_ID}:${GROUP_ID} --service fpm \
  && docker-php-serversideup-set-file-permissions --owner ${USER_ID}:${GROUP_ID} --service nginx

USER www-data
