#!/usr/bin/env bash

# Checa os arquivos .env

if [[ -f "${COMPOSE_PROJECT_DIR}/.env" ]]; then
    . "${COMPOSE_PROJECT_DIR}/.env"
else
    echo "Arquivo .env não encontrado na pasta do Docker."
    echo "Erros foram encontrados. Abortando..."
    return 1
fi

if [[ -f "${COMPOSE_PROJECT_DIR}/../../.env.local" ]]; then
    . "${COMPOSE_PROJECT_DIR}/../../.env.local"
else
    echo "Arquivo .env.local não encontrado na pasta do projeto."
    echo "Erros foram encontrados. Abortando..."
    return 1
fi

# Checa as variáveis de ambiente

declare -a env_vars=(
    # docker
    "COMPOSE_FILE"
    "COMPOSE_PROJECT_DIR"
    "COMPOSE_PROJECT_NAME"
    "DEV_DOCKER_IMAGE_PHP"
    "DEV_HOST_PORT_HTTP"
    "DEV_HOST_PORT_MYSQL"
    "DEV_GID"
    "DEV_UID"
    "MYSQL_DATABASE"
    "MYSQL_PASSWORD"
    "MYSQL_ROOT_PASSWORD"
    "MYSQL_USER"

    # composer
    "COMPOSER_MEMORY_LIMIT"
    "DEV_COMPOSER_DIR"

    # aplicação
    "APP_BASE_URL"
)

env_checks=true

for i in "${env_vars[@]}"; do
    if [[ -z ${!i} ]]; then
        echo "Variável ${i} não configurada."
        env_checks=false
    fi
done

if [[ "$env_checks" = false ]]; then
    echo "Erros foram encontrados. Abortando..."
    return 1
fi
