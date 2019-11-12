# Desenvolvimento

## Requisitos

1. Instale o [Docker][docker-install] e o [Docker Compose][compose-install], e
   adicione os binários à variável de ambiente `PATH`.
   
   **_Nota: As configurações a seguir são baseadas no Linux. Ajustes podem ser
   necessários para o uso do Docker Compose no ambiente Windows._** 

## Instalação

### Variáveis de Ambiente

1. Acesse o diretório `.deploy/local`, crie um arquivo `.env` a partir do
   arquivo `.env.dist`, e crie as variáveis usadas nos contêineres:

    | Variável              | Descrição                                                                               |
    | --------------------- | --------------------------------------------------------------------------------------- |
    | COMPOSE_FILE          | O(s) arquivo(s) de configuração do docker-compose.                                      |
    | COMPOSE_PROJECT_DIR   | O diretório docker-compose do projeto para configuração local.                          |
    | COMPOSE_PROJECT_NAME  | Nome do projeto usado como prefixo ao criar os contêineres.                             |
    | COMPOSER_MEMORY_LIMIT | Configuração para evitar [erros de limite de memória][memory-limit-errors] do Composer. |
    | DEV_COMPOSER_DIR      | O diretório do Composer na máquina host, usado para cache dos pacotes baixados.         |
    | DEV_DOCKER_IMAGE_PHP  | Imagem Docker usada pelo serviço php.                                                   |
    | DEV_HOST_PORT_HTTP    | Porta HTTP usada na máquina host. Padrão: 80.                                           |
    | DEV_HOST_PORT_MYSQL   | Porta MySQL usada pela máquina host. Padrão: 3306.                                      |
    | DEV_GID               | O ID do grupo do usuário na máquina host, usado para evitar conflitos de permissões.    |
    | DEV_UID               | O ID do usuário na máquina host, usado para evitar conflitos de permissões.             |
    | MYSQL_DATABASE        | Banco de dados padrão.                                                                  |
    | MYSQL_PASSWORD        | Senha do usuário do MySQL.                                                              |
    | MYSQL_ROOT_PASSWORD   | Senha do usuário root do MySQL.                                                         |
    | MYSQL_USER            | Usuário do MySQL.                                                                       |

    Para obter o `$GID` e o `$UID` no Linux execute os seguintes comandos:

    ```
    id -u <user>

    id -g <group>
    ```

2. Em seguida, você pode executar os scripts auxiliares na pasta
   `.deploy/local/bin`:

    ```
    .deploy/local
    ├── bin
    │   ├── check-env.sh
    │   ├── install-env.sh
    │   └── set-aliases.sh
    ├── services
    │   ├── mysql
    │   ├── nginx
    │   └── php
    ├── docker-compose.yaml
    └── .env.dist
    .env
    ```

### Docker

1. A partir da **pasta raiz do projeto**, execute os seguintes comandos para
   criar aliases para as ferramentas de desenvolvimento:

    ```
    COMPOSE_PROJECT_DIR=${PWD}/.deploy/local

    . .deploy/local/bin/install-env.sh
    ```

2. Os seguintes aliases serão criados:

    * composer
    * console
    * dc
    * php

1. Construa as imagens do Docker:

    ```
    docker build -t ${DEV_DOCKER_IMAGE_PHP}:base .deploy/docker/base

    dc build --parallel
    ```

1. Execute os contêineres:

    ```
    dc up -d
    ```

    _Nota: Verifique se as portas do host configuradas para os serviços no arquivo
    `docker-compose.yaml` estão livres. A diretiva `ports` mapeia portas na
    máquina host para portas nos contêineres e segue o formato
    `<porta-no-host>:<porta-no-container>`.
    Mais informações na [referência do arquivo do Compose][compose-ports]._

1. Para parar os contêineres, execute:

    ```
    dc down
    ```

### Aplicação

1. Acesse o diretório raiz, crie um arquivo `.env.local` a partir do arquivo
   `.env`, e configure as variáveis usadas pela aplicação.

2. Então, execute o seguinte comando:

    ```
    composer install
    ```

[compose-install]: https://docs.docker.com/compose/install/
[compose-ports]: https://docs.docker.com/compose/compose-file/#ports
[docker-install]: https://docs.docker.com/install/
[memory-limit-errors]: https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors
