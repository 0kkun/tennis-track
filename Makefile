include .env

MYSQL_ROOT_LOGIN_CMD = mysql -u root -p'$(MYSQL_ROOT_PASSWORD)'
MYSQL_USER_LOGIN_CMD = mysql -u $(MYSQL_USER_NAME) -p'$(MYSQL_PASSWORD)' $(MYSQL_DB_NAME)
DCE = docker compose exec
DEI = docker exec -it

# *****************************
# *         For Build         *
# *****************************
.PHONY: init
init:
ifdef PROJECT_NAME
	@make down
	@make set-up
	@make build
	@make up
	@make composer-install
	@make npm-install
	$(DCE) app php artisan key:generate
	@make restart
	@make migrate
	@make seed
	@make test-init
else
	@echo "ERROR: PROJECT_NAME is not set. Please set PROJECT_NAME in your .env file."
	@exit 1
endif

# .envがなければ生成する
.PHONY: set-up
setup:
	@if [ -e ${SOURCE_DIR_NAME}/.env ] ; then \
		echo "${SOURCE_DIR_NAME}/.env already exists"; \
	else \
		cp ${SOURCE_DIR_NAME}/.env.example ${SOURCE_DIR_NAME}/.env; \
	fi

.PHONY: composer-install
composer-install:
	$(DCE) app composer install


# *****************************
# *       For Frontend        *
# *****************************
# .PHONY: npm-install
# npm-install:
# 	$(DCE) app npm install

# .PHONY: npm-run
# npm-run:
# 	$(DEI) $(PROJECT_NAME)_app npm run dev

# .PHONY: lint
# lint:
# 	$(DEI) $(PROJECT_NAME)_app npm run lint

# .PHONY: format
# format:
# 	$(DEI) $(PROJECT_NAME)_app npm run format

.PHONY: npm-install
npm-install:
	cd frontend; npm install

.PHONY: npm-run
npm-run:
	cd frontend; npm run dev

.PHONY: lint
lint:
	cd frontend; npm run lint

.PHONY: format
format:
	$(DEI) $(PROJECT_NAME)_app npm run format

.PHONY: open_frontend
open_frontend:
	open http://localhost:3000


# *****************************
# *      Laravel Command      *
# *****************************
.PHONY: migrate
migrate:
	$(DEI) $(PROJECT_NAME)_app php artisan migrate

.PHONY: migrate-fresh
migrate-fresh:
	$(DEI) $(PROJECT_NAME)_app php artisan migrate:fresh

.PHONY: migrate-rollback
migrate-rollback:
	$(DEI) $(PROJECT_NAME)_app php artisan migrate:rollback

.PHONY: migrate-status
migrate-status:
	$(DEI) $(PROJECT_NAME)_app php artisan migrate:status

.PHONY: migrate-reset
migrate-reset:
	$(DEI) $(PROJECT_NAME)_app php artisan migrate:reset

.PHONY: $(PROJECT_NAME)_seed
seed:
	$(DEI) $(PROJECT_NAME)_app php artisan db:seed

.PHONY: dump
dump:
	$(DEI) $(PROJECT_NAME)_app composer dump-autoload

.PHONY: test
test:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/phpunit

.PHONY: single-test
single-test:
	@read -p "Enter a test file path or class name: " TESTPATH; \
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/phpunit --filter $$TESTPATH --testdox

.PHONY: package-test
package-test:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/phpunit --testdox --filter Packages

.PHONY: unit-test
unit-test:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/phpunit --testdox --filter Unit

.PHONY: feature-test
feature-test:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/phpunit --testdox --filter Feature

.PHONY: pint-check
pint-check:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/pint --test

.PHONY: pint
pint:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/pint --dirty

.PHONY: pint-all
pint-all:
	$(DEI) $(PROJECT_NAME)_app ./vendor/bin/pint

.PHONY: ide-helper
ide-helper:
	$(DEI) $(PROJECT_NAME)_app php artisan ide-helper:models --nowrite

.PHONY: config-reset
config-reset:
	$(DEI) $(PROJECT_NAME)_app php artisan config:clear
	$(DEI) $(PROJECT_NAME)_app php artisan config:cache

# *****************************
# *     Container Controll    *
# *****************************
.PHONY: build_c
build_c:
	docker compose build --no-cache --force-rm

.PHONY: build
build:
	docker compose build

.PHONY: up
up:
	docker compose up -d

.PHONY: stop
stop:
	docker compose stop

.PHONY: down
down:
	docker compose down --remove-orphans

.PHONY: app
app:
	$(DCE) app bash

.PHONY: db
db:
	$(DCE) db bash

.PHONY: nginx
nginx:
	$(DCE) nginx bash

.PHONY: redis
redis:
	$(DCE) redis redis-cli

.PHONY: restart
restart:
	@make down
	@make up

.PHONY: open-mailhog
open-mailhog:
	open http://localhost:8025

# *****************************
# *        Schemaspy          *
# *****************************
# .PHONY: ss-run
# ss-run:
# 	docker compose run --rm schemaspy

# .PHONY: ss-open
# ss-open:
# 	open .docker/schemaspy/output/index.html

.PHONY: ss-image
ss-image:
	cd .docker/schemaspy && docker build -t tennis-track-er-document .

.PHONY: ss-run
ss-run:
	docker run --platform linux/amd64 --net host -v $(PWD)/.docker/schemaspy/output:/output --rm tennis-track-er-document

# *****************************
# *           MySql           *
# *****************************
.PHONY: mysql
mysql:
	$(DCE) db bash -c '$(MYSQL_USER_LOGIN_CMD)'

.PHONY: mysql-root
mysql-root:
	$(DCE) db bash -c '$(MYSQL_ROOT_LOGIN_CMD)'

.PHONY: show-dbuser
show-dbuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="SELECT user, host FROM mysql.user ORDER BY user, host"

.PHONY: show-dbgrants
show-dbgrants:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_USER_LOGIN_CMD) --execute="SHOW GRANTS;"

.PHONY: show-databases
show-databases:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_USER_LOGIN_CMD) --execute="SHOW DATABASES"

.PHONY: grant-testdbuser
grant-testdbuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="USE $(MYSQL_DB_NAME)_testing; GRANT ALL ON `$(MYSQL_DB_NAME)_testing`.* TO `$(MYSQL_USER_NAME)`"

.PHONY: create-testdb
create-testdb:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="CREATE DATABASE `$(PROJECT_NAME)_db_testing`;"

# Sequero Ace接続用
.PHONY: create-localuser
create-localuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="CREATE USER $(MYSQL_USER_NAME)'@'127.0.0.1' IDENTIFIED BY 'password';"

.PHONY: grant-dbuser
grant-dbuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="GRANT ALL PRIVILEGES ON $(MYSQL_DB_NAME).* TO '$(MYSQL_USER_NAME)'@'127.0.0.1';"

.PHONY: test-init
test-init:
ifdef PROJECT_NAME
	@make create-testdb
	@make grant-testdbuser
	@make show-dbgrants
	@make show-databases
else
	@echo "ERROR: PROJECT_NAME is not set. Please set PROJECT_NAME in your .env file."
	@exit 1
endif

# *****************************
# *          Others           *
# *****************************
.PHONY: open_minio
open_minio:
	open http://localhost:9001


# *****************************
# *       New laravel pj      *
# *****************************
.PHONY: new-project
new-project:
	@make build_c
	@make up
	@make create-laravel
	@make mv-dir
	@make remove-temporary

.PHONY: create-laravel
create-laravel:
	$(DCE) app composer create-project "laravel/laravel=9.*" temporary --prefer-dist

.PHONY: mv-dir
mv-dir:
	cd ${SOURCE_DIR_NAME}/temporary; mv * .[^\.]* ../

.PHONY: remove-temporary
remove-temporary:
	rm -r ${SOURCE_DIR_NAME}/temporary