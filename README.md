## php-example-symfony-7-api

### config:
- host: local.api.symfony7.com

## migration
using symfony cli or php cli
- symfony console make:migration -> OR -> php bin/console make:migration
- symfony console doctrine:migrations:migrate -> OR -> php bin/console doctrine:migrations:migrate 

## Start Up
docker-compose up -d