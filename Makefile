include .env

MYSQL_ROOT_LOGIN_CMD = mysql -u root -p$(MYSQL_ROOT_PASSWORD)
MYSQL_USER_LOGIN_CMD = mysql -u $(MYSQL_USER_NAME) -p$(MYSQL_PASSWORD) $(MYSQL_DB_NAME)
DCE = docker-compose exec
DEI = docker exec -it

# *****************************
# *         For Build         *
# *****************************
.PHONY: init
init:
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

.PHONY: set-up
set-up:
	cp ${SOURCE_DIR_NAME}/.env.example ${SOURCE_DIR_NAME}/.env

.PHONY: composer-install
composer-install:
	$(DCE) app composer install


# *****************************
# *       For Frontend        *
# *****************************
.PHONY: npm-install
npm-install:
	$(DCE) app npm install

.PHONY: npm-run
npm-run:
	$(DEI) $(PROJECT_NAME)_app npm run dev

.PHONY: lint
lint:
	$(DEI) $(PROJECT_NAME)_app npm run lint

.PHONY: format
format:
	$(DEI) $(PROJECT_NAME)_app npm run format


# *****************************
# *      Laravel Command      *
# *****************************
.PHONY: migrate
migrate:
	$(DCE) app php artisan migrate:fresh

.PHONY: seed
seed:
	$(DCE) app php artisan db:seed

.PHONY: dump
dump:
	$(DEI) $(PROJECT_NAME)_app composer dump-autoload

.PHONY: test
test:
	docker exec $(PROJECT_NAME)_app ./vendor/bin/phpunit --testdox

# *****************************
# *     Container Controll    *
# *****************************
.PHONY: build_c
build_c:
	docker-compose build --no-cache --force-rm

.PHONY: build
build:
	docker-compose build

.PHONY: up
up:
	docker-compose up -d

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down --remove-orphans

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
.PHONY: ss-run
ss-run:
	docker-compose run --rm schemaspy

.PHONY: ss-open
ss-open:
	open .docker/schemaspy/output/index.html

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
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_USER_LOGIN_CMD) --execute="SHOW GRANTS"

.PHONY: show-databases
show-databases:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_USER_LOGIN_CMD) --execute="SHOW DATABASES"

.PHONY: grant-testdbuser
grant-testdbuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="GRANT ALL ON $(MYSQL_DB_NAME)_testing.* TO $(MYSQL_USER_NAME)"

.PHONY: create-testdb
create-testdb:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="CREATE DATABASE $(PROJECT_NAME)_db_testing"

# Sequero Ace接続用
.PHONY: create-localuser
create-localuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="CREATE USER 'tennis_track_user'@'127.0.0.1' IDENTIFIED BY 'password'"

.PHONY: grant-dbuser
grant-dbuser:
	$(DEI) $(PROJECT_NAME)_db $(MYSQL_ROOT_LOGIN_CMD) --execute="GRANT ALL PRIVILEGES ON $(MYSQL_DB_NAME).* TO 'tennis_track_user'@'127.0.0.1'"

.PHONY: test-init
test-init:
	@make create-testdb
	@make grant-testdbuser
	@make show-dbgrants
	@make show-databases


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