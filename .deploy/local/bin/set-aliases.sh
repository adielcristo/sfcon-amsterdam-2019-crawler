#!/usr/bin/env bash

alias composer="dc \
    exec php composer $@"

alias console="dc \
    exec php bin/console $@"

alias dc="docker-compose \
    --project-directory ${COMPOSE_PROJECT_DIR} \
    --file ${COMPOSE_PROJECT_DIR}/docker-compose.yaml \
    $@"

alias php="dc \
    exec php php $@"
