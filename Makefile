# first setup application by 1 command
build:
	docker-compose -f compose.yaml build
	docker-compose -f compose.yaml up -d
	docker-compose -f compose.yaml exec php composer install
	docker-compose -f compose.yaml exec php php bin/console doctrine:database:create --if-not-exists
	docker-compose -f compose.yaml exec php php bin/console doctrine:migrations:migrate --no-interaction

# run application
up:
	docker-compose -f compose.yaml up -d

# stop application
down:
	docker-compose -f compose.yaml down

consume:
	docker-docker -f compose.yaml exec php php bin/console messenger:consume --limit=20

redis_flush:
	docker-compose -f compose.yaml exec redis redis-cli flushall