# first setup application by 1 command
build:
	docker-compose -f compose.yaml build
	docker-compose -f compose.yaml up -d
	docker-compose -f compose.yaml exec php composer install
	docker-compose -f compose.yaml exec php php bin/console doctrine:database:create --if-not-exists

# run application
up:
	docker-compose -f compose.yaml up -d

# stop application
down:
	docker-compose -f compose.yaml down