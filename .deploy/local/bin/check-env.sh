#!/usr/bin/env bash

# Check .env files

if [[ -f "${COMPOSE_PROJECT_DIR}/.env" ]]; then
    . "${COMPOSE_PROJECT_DIR}/.env"
else
    echo ".env file not found on docker folder."
    echo "Errors were found. Aborting..."
    return 1
fi

if [[ -f "${COMPOSE_PROJECT_DIR}/../../.env.local" ]]; then
    . "${COMPOSE_PROJECT_DIR}/../../.env.local"
else
    echo ".env.local file not found on project folder."
    echo "Errors were found. Aborting..."
    return 1
fi

# Check env vars

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

    # application
    "APP_BASE_URL"
)

env_checks=true

for i in "${env_vars[@]}"; do
    if [[ -z ${!i} ]]; then
        echo "Variable ${i} unset."
        env_checks=false
    fi
done

if [[ "$env_checks" = false ]]; then
    echo "Errors were found. Aborting..."
    return 1
fi
