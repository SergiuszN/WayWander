# WayWander

Awesome mega smoothie unicorn application that can navigate you through the world! 

## Installation

You need to have free 8081 port in the system 
and installed docker with docker-compose, then just run: 

```bash
$ make up
$ make install
```

Or alternatively if you for some reason do not have 
make installed in the system just use these commands: 

```bash
$ docker-compose up -d
$ docker-compose exec php bash
$ composer install
```

Now navigate to http://localhost:8081/routing/CZE/ITA

## Testing

For spin app all tests just type: 

```bash
$ make test
```

OR: 

```bash
$ docker-compose exec php bash
$ php bin/phpunit
```

