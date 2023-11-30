build:
	docker-compose -f docker-compose.dev.yml up --build
up:
	docker-compose -f docker-compose.dev.yml up -d
down:
	docker-compose -f docker-compose.dev.yml down
php-root:
	docker exec -it recap-app sh
mysql-root:
	docker exec -it recap-mysql sh
