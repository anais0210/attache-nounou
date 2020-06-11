#!make
include .env

.PHONY: help
.DEFAULT_GOAL := help
RUN_IN_CONTAINER := docker exec -t ${PROJECT_HOST}
SUBCOMMAND = $(subst +,-, $(filter-out $@,$(MAKECMDGOALS)))
help:
	@clear
	@echo -e "$$(grep -hE '^\S+:.*##' $(MAKEFILE_LIST) | sed -e 's/:.*##\s*/:/' -e 's/^\(.\+\):\(.*\)/\\x1b[36m\1\\x1b[m:\2/' | column -c2 -t -s :)"

# --------------------------------------------------------------------
# PROJECT
# --------------------------------------------------------------------

start: docker-start composer-install symfony-clear-cache ## Démarre les containers du projet, installe les dépendances et vide le cache symfony

stop: docker-stop ## Stop les containers du projet

restart: stop start ## Stop et redémarre les containers du projet, installe les dépendances et vide le cache symfony

rebuild:  docker-rebuild composer-install symfony-clear-cache ## Stop, supprime et recréer les containers du projet, install les dépendances et vide le cache symfony

# --------------------------------------------------------------------
# DOCKER
# --------------------------------------------------------------------
docker-logs:
	docker-compose -f docker/docker-compose.yml logs -f ${SUBCOMMAND}

docker-start: ## Demarre les containers du projet
ifndef ARCHI
	docker-compose -f docker/docker-compose.yml up --build -d
else
	docker-compose -f docker/docker-compose.yml up --build -d
endif

docker-stop: ## Stop les containers du projet
	 docker-compose -f docker/docker-compose.yml stop

docker-rebuild: docker-clean-containers docker-start ## Stop, supprime et recréer les containers du projet

docker-clean-containers: docker-stop ## Stop et supprime les containers du projet
	 docker-compose -f docker/docker-compose.yml rm  --force

docker-clean-images: ## Supprime toute les images docker
	 docker rmi $$(docker images -q)

docker-clean-log: ## Supprime les logs nginx et postgresql
	 rm -rf ./docker/logs/nginx/access.log
	 rm -rf ./docker/logs/nginx/error.log
	 rm -rf ./docker/logs/postgres/postgresql-11-main.log

docker-hard-reset: ## !!!! Supprime tout container, volume, image, ...
	 docker stop $$(docker ps -a -q); docker rm $$(docker ps -a -q); docker volume rm $$(docker volume ls -qf dangling=true); docker rmi $$(docker images -q) --force

# --------------------------------------------------------------------
# SYMFONY
# --------------------------------------------------------------------

symfony-clear-cache: ## Symfony clear cache
	 @${RUN_IN_CONTAINER} php ./bin/console cache:clear --no-warmup
	 @${RUN_IN_CONTAINER} php ./bin/console cache:clear --no-warmup -e test

# --------------------------------------------------------------------
# COMPOSER
# --------------------------------------------------------------------

composer-install: ## Composer install
	composer install;

# --------------------------------------------------------------------
# TEST
# --------------------------------------------------------------------
test-behat: ## Behat
ifdef suite
	@${RUN_IN_CONTAINER} ./vendor/bin/behat --lang=fr --colors --suite=$(suite)
else
ifdef tags
	@${RUN_IN_CONTAINER} ./vendor/bin/behat --lang=fr --colors --tags=$(tags)
else
	@${RUN_IN_CONTAINER} ./vendor/bin/behat --lang=fr --colors
endif
endif

test-phpunit: ## PHP Unit
	@${RUN_IN_CONTAINER} ./vendor/bin/simple-phpunit --configuration ./phpunit.xml.dist ${SUBCOMMAND}

test-phpcs: ## PHP Code Style
	@${RUN_IN_CONTAINER} ./vendor/bin/phpcbf ${SUBCOMMAND}
	@${RUN_IN_CONTAINER} ./vendor/bin/phpcs ${SUBCOMMAND}

test-phpcbf: ## PHP Code Beautifier and Fixer
	@${RUN_IN_CONTAINER} ./vendor/bin/phpcbf ${SUBCOMMAND}

test-phpstan: ## PhpStan
	@${RUN_IN_CONTAINER} ./vendor/bin/phpstan analyse -c tests/phpstan/phpstan.neon

test-psalm: ## Psalm
	@${RUN_IN_CONTAINER} ./vendor/bin/psalm
# --------------------------------------------------------------------
# FIXTURES
# --------------------------------------------------------------------

load-fixtures: ## Génère les fixtures
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:database:drop --if-exists --force ${SUBCOMMAND}

# --------------------------------------------------------------------
# DOCTRINE
# --------------------------------------------------------------------

console-doctrine-database-create: ## Création de la base de donnée postgres.
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:database:create ${SUBCOMMAND}

console-doctrine-database-drop: ## Drop de la base de donnée postgres.
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:database:drop --if-exists --force ${SUBCOMMAND}

console-doctrine-schema-update:  ## Drop de la base de donnée postgres.
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:schema:update --force ${SUBCOMMAND}

# --------------------------------------------------------------------
# DOCUMENTATION
# --------------------------------------------------------------------

generate-swagger-file: ## Génère le fichier swagger
	@${RUN_IN_CONTAINER} ./vendor/bin/openapi ./src -o ./config/swagger/swagger.yaml --format yaml

# --------------------------------------------------------------------
# DATABASES
# --------------------------------------------------------------------

databases-refresh: ## Drop toutes les bases de donnée (postgres).
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:database:drop --if-exists --force ${SUBCOMMAND}
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:database:create ${SUBCOMMAND}
	 @${RUN_IN_CONTAINER} php ./bin/console doctrine:schema:update --force ${SUBCOMMAND}

# --------------------------------------------------------------------
# APPLICATION
# --------------------------------------------------------------------
php: ## PHP
	@${RUN_IN_CONTAINER} php ${SUBCOMMAND}