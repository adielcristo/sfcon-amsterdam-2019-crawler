ARG BASE_IMAGE

FROM ${BASE_IMAGE} AS base

MAINTAINER Adiel Cristo <adielcristo@gmail.com>

# Install Xdebug
RUN yes | pecl install xdebug && \
    docker-php-ext-enable xdebug
