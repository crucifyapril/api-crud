IMAGE = task
VERSION = 1.0
WORK_DIR = /var/www

COMPOSER_IMAGE=registry.gitlab.com/img-docker/composer

export IMAGE
export VERSION
export WORK_DIR

.PHONY: logs tests artisan migrate seed env key-generate build up down restart clean clean-logs clean-vendor optimize npm-install npm-build npm-dev npm-run phpcs

build:
	@docker compose build --build-arg IMAGE=$(IMAGE) --build-arg VERSION=$(VERSION)
up:
	@docker compose up -d
down:
	@docker compose down
restart:
	@docker compose down && docker-compose up -d

logs:
	@docker compose logs -f

vendor:
	@docker run -it --rm -v .:$(WORK_DIR) $(COMPOSER_IMAGE) install
require:
	@docker run -it --rm -v .:$(WORK_DIR) $(COMPOSER_IMAGE) require $1

migrate:
	@docker run -it --rm -w $(WORK_DIR) -v .:$(WORK_DIR) --network=web-network-task --user 1000:1000 $(IMAGE):$(VERSION) php artisan migrate
seed:
	@docker run -it --rm -w $(WORK_DIR) -v .:$(WORK_DIR) --network=web-network-task --user 1000:1000 $(IMAGE):$(VERSION) php artisan db:seed
env:
	@cp .env.example .env
key-generate:
	@docker run -it --rm -w $(WORK_DIR) -v .:$(WORK_DIR) --user 1000:1000 $(IMAGE):$(VERSION) php artisan key:generate

jwt-secret:
	@docker run -it --rm -w $(WORK_DIR) -v .:$(WORK_DIR) --user 1000:1000 $(IMAGE):$(VERSION) php artisan jwt:secret

# Пример: make artisan c='php artisan tinker'
artisan:
	@docker run -it --rm -v .:$(WORK_DIR) --network=web-network-task --user 1000:1000 $(IMAGE):$(VERSION) $(c)
optimize:
	@docker run -it --rm -v .:$(WORK_DIR) --network=web-network-task --user 1000:1000 $(IMAGE):$(VERSION) php artisan optimize:clear

clean: clean-logs optimize clean-vendor
clean-logs:
	@sudo rm -fr ./.docker/logs/nginx/*
clean-vendor:
	@rm -fr ./vendor && rm -fr ./node_modules

npm-install:
	@docker run -it --rm -v $$(pwd):/app -w /app --user 1000:1000 node:22.11 npm i
npm-build:
	@docker run -it --rm -v $$(pwd):/app -w /app --user 1000:1000 node:22.11 npm run build
npm-dev:
	@docker run -it --rm -v $$(pwd):/app -w /app --user 1000:1000 -p 5173:5173 node:22.11 npm run dev

# Пример: make npm-run cmd='npm install -D tailwindcss'
npm-run:
	@docker run -it --rm -v $$(pwd):/app -w /app --user 1000:1000 node:22.11 $(cmd)
