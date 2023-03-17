DOCKER_BASH=docker exec -it justhireit-php
BIN_CONSOLE=php bin/console

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

rebuild:
	docker-compose down
	docker-compose build
	docker-compose up -d
	${DOCKER_BASH} composer install

install:
	${DOCKER_BASH} composer install
	${DOCKER_BASH} ${BIN_CONSOLE} d:s:d --force
	${DOCKER_BASH} ${BIN_CONSOLE} d:s:c

bash:
	docker exec -it justhireit-php bash

db-bash:
	docker exec -it justhireit-db bash

restart:
	docker-compose down
	docker-compose up -d

pu:
	${DOCKER_BASH} ./vendor/phpunit/phpunit/phpunit
