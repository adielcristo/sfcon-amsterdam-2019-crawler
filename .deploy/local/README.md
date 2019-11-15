# Development

## Requirements

1. Install [Docker][docker-install] and [Docker Compose][compose-install],
   and add the binaries to the `PATH` environment variable.
   
   _Note: The following configurations are based on a Linux setup. Adjustments
   may be required to use Docker Compose in the Windows setup._

## Installation

### Environment Variables

1. Access the `.deploy/local` directory, create an `.env` file from `.env.dist`,
   and set up the variables used on the containers:

    | Variable              | Description                                                           |
    | --------------------- | --------------------------------------------------------------------- |
    | COMPOSE_FILE          | The project docker-compose yaml file(s).                              |
    | COMPOSE_PROJECT_DIR   | The project docker-compose directory for local config.                |
    | COMPOSE_PROJECT_NAME  | Project name used as prefix when creating containers.                 |
    | COMPOSER_MEMORY_LIMIT | Prevent memory limit errors as explained [here][memory-limit-errors]. |
    | DEV_COMPOSER_DIR      | Your local composer directory, on your host machine, used for cache.  |
    | DEV_DOCKER_IMAGE_PHP  | Docker image used by the php service.                                 |
    | DEV_HOST_PORT_HTTP    | HTTP port used on the host machine. Default: 80.                      |
    | DEV_HOST_PORT_MYSQL   | MySQL port used on host machine. Default: 3306.                       |
    | DEV_GID               | The user group id, used to prevent permissions errors.                |
    | DEV_UID               | The user id, used to prevent permissions errors.                      |
    | MYSQL_DATABASE        | Default database.                                                     |
    | MYSQL_PASSWORD        | MySQL user password.                                                  |
    | MYSQL_ROOT_PASSWORD   | MySQL root password.                                                  |
    | MYSQL_USER            | MySQL user.                                                           |

    To get the `$GID` and `$UID` run the following commands:

    ```
    id -u <user>

    id -g <group>
    ```

2. Then you can execute the helper scripts from the `.deploy/local/bin` folder:

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

1. From the **project root folder**, run the following commands to create
   aliases for the development tools:

    ```
    COMPOSE_PROJECT_DIR=${PWD}/.deploy/local

    . .deploy/local/bin/install-env.sh
    ```

2. The following aliases will be created:

    * composer
    * console
    * dc
    * php

1. Build the docker images:

    ```
    docker build -t ${DEV_DOCKER_IMAGE_PHP}:base .deploy/docker/base

    dc build --parallel
    ```

1. Run the containers:

    ```
    dc up -d
    ```

    _Note: Make sure the host ports set up to the services on the
    `docker-compose.yaml` file are free. The `ports` directive maps ports on the
    host machine to ports on the containers and follows the format
    `<host-port>:<container-port>`. More info on the
    [Compose file reference][compose-ports]._

1. To stop the containers, run:

    ```
    dc down
    ```

### Application

1. Access the root directory, create an `.env.local` file from `.env`, and set
   up the variables used on the application.

2. Then, run the following command:

    ```
    composer install
    ```

[compose-install]: https://docs.docker.com/compose/install/
[compose-ports]: https://docs.docker.com/compose/compose-file/#ports
[docker-install]: https://docs.docker.com/install/
[memory-limit-errors]: https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors
