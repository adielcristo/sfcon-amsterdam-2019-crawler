#!/usr/bin/env bash

# Não sair se ocorrer um erro
set +e
set -o pipefail

# Checa os requisitos e instala o ambiente

if [[ -z ${COMPOSE_PROJECT_DIR} ]]; then
    echo "Variável COMPOSE_PROJECT_DIR não configurada."
    return 1
fi

. "${COMPOSE_PROJECT_DIR}/bin/check-env.sh"

. "${COMPOSE_PROJECT_DIR}/bin/set-aliases.sh"
