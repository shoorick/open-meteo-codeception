.PHONY: server test unit acceptance chrome

CODECEPTION=vendor/bin/codecept
URL=127.0.0.1:8000

current:
	curl 'https://api.open-meteo.com/v1/forecast?latitude=44&longitude=20&daily=sunrise,sunset&current=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m,surface_pressure&timezone=Europe%2FBerlin&forecast_days=1&wind_speed_unit=ms' | jq . | tee current-belgrade.json

hourly:
	curl 'https://api.open-meteo.com/v1/forecast?latitude=44&longitude=20&hourly=temperature_2m,relative_humidity_2m,wind_speed_10m,wind_direction_10m,wind_gusts_10m,precipitation&timezone=Europe%2FBerlin&forecast_days=1&wind_speed_unit=ms' | jq . | tee hourly-belgrade.json

server:
	echo "Server started at http://$(URL)"
	php -S $(URL) -t .

# Codeception tests
# suppose that chromedriver is running
test:
	$(CODECEPTION) run

unit:
	$(CODECEPTION) run unit

# try to start chromedriver before running acceptance tests
acceptance:
	chromedriver --port=9515 --url-base=/wd/hub > /dev/null 2>&1 & echo $$! > /tmp/chromedriver.pid; \
	sleep 2; \
	$(CODECEPTION) run acceptance || { EXIT_CODE=$$?; kill `cat /tmp/chromedriver.pid`; rm /tmp/chromedriver.pid; exit $$EXIT_CODE; }; \
	kill `cat /tmp/chromedriver.pid`; \
	rm /tmp/chromedriver.pid

chrome:
	chromedriver --port=9515 --url-base=/wd/hub > /dev/null 2>&1 & echo $$! > /tmp/chromedriver.pid
