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
```docker 
docker-composer exec app php bin/phpunit
# Example How run only one test
docker-composer exec app php bin/phpunit tests/integration/BookApiClientTest.php
```

#### Create Test Db
```phpunit 
docker-composer exec app php bin/console doctrine:database:create
```

```php-cli
php bin/console make:command
```
