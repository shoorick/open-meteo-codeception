# Open-Meteo and Codeception example

An example of PHP application using
[Open-Meteo](https://open-meteo.com) weather data
and [Codeception](https://codeception.com) tests.

![icon](icon-128.png)


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

### Command line

```bash
./vendor/bin/codecept run
```
### VSCode, Codium, Cursor, Windsurf

1. Install [Codeception test adapter](https://github.com/shoorick/codeception-test-adapter) for VSCode if necessary
2. Open **Testing** panel: <kbd>F1</kbd> or <kbd>Ctrl+Shift+P</kbd> and then choose `View: Show Testing` or click on the flask icon in the left sidebar
3. Hover over the suite, file or method name and click on the ▷ play icon

![Screenshot](https://github.com/shoorick/codeception-test-adapter/raw/master/screenshot.png)

## See also

- [Codeception test adapter](https://github.com/shoorick/codeception-test-adapter) for VSCode
  and compatible IDEs (Codium, Cursor, Windsurf)
- [open-meteo.com](https://open-meteo.com)
- [codeception.com](https://codeception.com/)
