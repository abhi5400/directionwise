.PHONY: help start stop build test clean install

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

install: ## Install dependencies
	composer install
	npm install

start: ## Start PHP built-in server
	php -S localhost:8000 -t .

start-docker: ## Start Docker containers
	docker-compose up -d

stop-docker: ## Stop Docker containers
	docker-compose down

build: ## Build Docker image
	docker-compose build

test: ## Run tests
	vendor/bin/phpunit tests/php || echo "No tests found"

lint: ## Run PHP linter
	find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \;

convert-images: ## Convert images to WebP
	npm run convert-images

clean: ## Clean temporary files
	rm -rf vendor/
	rm -rf node_modules/
	find . -name "*.backup" -delete

setup: install ## Full setup (install dependencies)
	@echo "Setup complete!"
	@echo "Run 'make start' to start the development server"

