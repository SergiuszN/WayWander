DOCKER_COMP = docker-compose
PHP_CONT = $(DOCKER_COMP) exec php
EXEC_CONT = $(DOCKER_COMP) exec php sh -c

## —— 🎵 🐳 The Symfony-docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker
	@$(DOCKER_COMP) up --detach

stop: ## Stop the docker
	@$(DOCKER_COMP) stop

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) bash

## —— Project ————————————————————————————————————————————————————————————————
install: ## Compile project
	@$(EXEC_CONT) "\
			composer install; \
		"

test: ## Run tests
	@$(EXEC_CONT) "\
			php bin/phpunit; \
		"

check: ## Run code quality checks
	@$(EXEC_CONT) "\
    			vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix; \
    			vendor/bin/deptrac analyse --config-file=deptrac.yaml; \
    		"
