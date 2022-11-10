# Intention of docker commands

start:
	(cd docker && docker-compose up -d --remove-orphans)

exec:
	(cd docker && docker-compose exec service-php-fpm bash)

stop:
	(cd docker && docker-compose stop)

clean-database:
	(cd docker && docker-compose rm service-mariadb)

build:
	(cd docker && docker-compose build)