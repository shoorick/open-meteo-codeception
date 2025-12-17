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
make server
# or
php -S 127.0.0.1:8080 -t .
```

Then open http://127.0.0.1:8080/index.php

## Run tests

```bash
./vendor/bin/codecept run unit
```

## See also

- [Codeception test adapter](https://github.com/shoorick/codeception-test-adapter) for VSCode
  and compatible IDEs (Codium, Cursor, Windsurf)
- [open-meteo.com](https://open-meteo.com)
- [codeception.com](https://codeception.com/)
