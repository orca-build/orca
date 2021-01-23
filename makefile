# Makefile  Project

.PHONY: help
.DEFAULT_GOAL := help


#------------------------------------------------------------------------------------------------

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

#------------------------------------------------------------------------------------------------

build: ## Builds ORCA and creates orca.phar
	@cd src && composer install --no-dev
	@echo "===================================================================="
	@echo "verifying if phar files can be created....phar.readonly has to be OFF"
	@php -i | grep phar.readonly
	@php -i | grep "Loaded Configuration" 
	@php build.php

#------------------------------------------------------------------------------------------------

install: ## Installs all dev dependencies
	@cd src && composer install

test: ## Runs all tests
	@php ./src/vendor/bin/phpunit --configuration=phpunit.xml -v

sample: ## build and creates a new sample image
	@php ./build/orca.phar --directory=./samples/php-image
