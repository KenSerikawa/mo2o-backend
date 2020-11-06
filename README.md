# mo2o backend exercise

## Setup

```
$ git clone https://www.github.com/KenSerikawa/mo2o-backend

$ cd mo2o-backend

$ composer install

$ cd public

$ php -S 127.0.0.1:8000
```

## Routes
Para probar los servicios es necesario acceder mediante las siguientes rutas:
- `GET /beers`
- `GET /beers?food=apple`
- `GET /beers/1`

## Tests
Para ejecutar los tests unitarios:
```
$ php bin/phpunit --testdox
```







