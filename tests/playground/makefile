# Makefile  Project

.PHONY: help
.DEFAULT_GOAL := help

#------------------------------------------------------------------------------------------------

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

#------------------------------------------------------------------------------------------------

generate: ## build and creates a new sample image
	@php ../..//build/orca.phar generate --directory=./php-image --debug
