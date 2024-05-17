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


# *****************************
# *        Schemaspy          *
# *****************************
.PHONY: ss-image
ss-image:
	docker build -t tennis-track-er-document .

.PHONY: ss-run
ss-run:
	docker run --platform linux/amd64 --net host -v $(PWD)/output:/output --rm tennis-track-er-document
