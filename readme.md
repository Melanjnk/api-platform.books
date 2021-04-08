# TDD + API-PLATFORM

### Quick Start

```docker
# Run application
docker-composer up -d
# Composer install
docker-composer exec app composer install
# Clear cache
docker-composer exec app php bin/console c:c
```
#### Run Tests
```phpunit 
docker-composer exec app php bin/phpunit
```

#### Create Test Db
```phpunit 
docker-composer exec app php bin/console doctrine:database:create
```

```php-cli
php bin/console make:command
```
