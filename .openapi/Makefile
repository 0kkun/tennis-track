DCE = docker-compose exec

# *****************************
# *         For Build         *
# *****************************
.PHONY: init
init:
	@make create-api_spec
	@make build
	@make up

.PHONY: create-api_spec
create-api_spec:
	touch ./src/api_spec.yaml

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

.PHONY: swagger-ui
swagger-ui:
	$(DCE) swagger-ui sh

.PHONY: swagger-api
swagger-api:
	$(DCE) swagger-api sh

.PHONY: restart
restart:
	@make down
	@make up

.PHONY: open
open:
	open http://localhost:10082

# *****************************
# *  merge api_spec.yaml      *
# *****************************
.PHONY: merge-api
merge-api:
	docker-compose run --rm swagger-merger
