# Open-Meteo and Codeception example

An example of PHP application using
[Open-Meteo](https://open-meteo.com) weather data
and [Codeception](https://codeception.com) tests.

## Requirements

- PHP 8
- Composer

## Install dependencies

```bash
composer install
```

## Run web app

```bash
php -S 127.0.0.1:8080 -t .
```

Open http://127.0.0.1:8080/index.php

## Run tests

```bash
./vendor/bin/codecept run unit
```

## See also

- [open-meteo.com](https://open-meteo.com)
- [codeception.com](https://codeception.com/)
