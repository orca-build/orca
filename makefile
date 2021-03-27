# Makefile  Project

.PHONY: help
.DEFAULT_GOAL := help


#------------------------------------------------------------------------------------------------

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

#------------------------------------------------------------------------------------------------

install: ## Installs all prod dependencies
	@cd src && composer install --no-dev

dev: ## Installs all dev dependencies
	@cd src && composer install

#------------------------------------------------------------------------------------------------

csfix: ## Starts the PHP CS Fixer
	@php ./src/vendor/bin/php-cs-fixer fix --config=./.php_cs.php --dry-run

stan: ## Starts the PHPStan Analyser
	@php ./src/vendor/bin/phpstan analyse -c ./.phpstan.neon

test: ## Runs all tests
	@php ./src/vendor/bin/phpunit --configuration=./phpunit.xml

#------------------------------------------------------------------------------------------------

pr: ## Runs and prepares everything for a pull request
	@php ./src/vendor/bin/php-cs-fixer fix --config=./.php_cs.php
	@make test -B
	@make stan -B

#------------------------------------------------------------------------------------------------

build: ## Builds ORCA and creates orca.phar
	@make install -B
	@echo "===================================================================="
	@echo "verifying if phar files can be created....phar.readonly has to be OFF"
	@php -i | grep phar.readonly
	@php -i | grep "Loaded Configuration"
	@php build.php
