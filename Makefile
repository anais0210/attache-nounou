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
	docker-compose -f docker/docker-compose.yml up --build -d

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
	 @${RUN_IN_CONTAINER} attache-nounou bin/console cache:clear --no-warmup
	 @${RUN_IN_CONTAINER} attache-nounou bin/console cache:clear --no-warmup -e test

# --------------------------------------------------------------------
# COMPOSER
# --------------------------------------------------------------------

composer-install: ## Composer install
	 @${RUN_IN_CONTAINER} attache-nounou composer install

# --------------------------------------------------------------------
# TEST && QUALITE
# --------------------------------------------------------------------
behat: ## Behat
	@${RUN_IN_CONTAINER} attache-nounou  vendor/bin/behat --colors

cs: ## PHP Code Style
	@${RUN_IN_CONTAINER} attache-nounou vendor/bin/phpcs --standard=PSR2 ./src

phpcbf: ## PHP Code Beautifier and Fixer
	@${RUN_IN_CONTAINER} attache-nounou vendor/bin/phpcbf ./src

phpstan: ## PhpStan
	@${RUN_IN_CONTAINER} attache-nounou  vendor/bin/phpstan analyse -l 6 src --memory-limit=4000M

psalm: ## Psalm
	 @${RUN_IN_CONTAINER} attache-nounou vendor/bin/psalm

# --------------------------------------------------------------------
# FIXTURES
# --------------------------------------------------------------------

fixtures: ## Génère les fixtures
	@${RUN_IN_CONTAINER} attache-nounou bin/console doctrine:fixtures:load ${SUBCOMMAND}

# --------------------------------------------------------------------
# DOCTRINE
# --------------------------------------------------------------------

database-create: ## Création de la base de donnée postgres.
	@${RUN_IN_CONTAINER} attache-nounou bin/console doctrine:database:create ${SUBCOMMAND}

doctrine-drop: ## Drop de la base de donnée postgres.
	@${RUN_IN_CONTAINER} attache-nounou bin/console doctrine:database:drop --if-exists --force ${SUBCOMMAND}

database-update:  ## Mise a jour de la base de donnée postgres.
	@${RUN_IN_CONTAINER} attache-nounou bin/console doctrine:schema:update --force ${SUBCOMMAND}

database-preview-update:
	@${RUN_IN_CONTAINER} attache-nounou bin/console doctrine:schema:update --dump-sql ${SUBCOMMAND}

# --------------------------------------------------------------------
# DOCUMENTATION
# --------------------------------------------------------------------

swagger: ## Génère le fichier swagger
	@${RUN_IN_CONTAINER} attache-nounou ./vendor/bin/swagger ./src -o ./Ressources/swagger/swagger.yaml

# --------------------------------------------------------------------
# DATABASES
# --------------------------------------------------------------------

databases-refresh: ## Drop la base de donnée et la recréer(postgres).
	php ./bin/console doctrine:database:drop --if-exists --force ${SUBCOMMAND}
	php ./bin/console doctrine:database:create ${SUBCOMMAND}
	php ./bin/console doctrine:schema:update --force ${SUBCOMMAND}

# --------------------------------------------------------------------
# APPLICATION
# --------------------------------------------------------------------
php: ## PHP
	@${RUN_IN_CONTAINER} php ${SUBCOMMAND}