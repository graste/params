ifdef PHP_PATH
	PHP=$(PHP_PATH)
else
	PHP=php
endif

help:

	@echo ""
	@echo "Available targets:"
	@echo ""
	@echo "  install         - install composer and vendor libraries"
	@echo "  update          - update composer and vendor libraries"
	@echo "  docs            - generate API documentation into 'docs/api' folder"
	@echo "  tests           - run all tests and create test coverage in 'build/reports"
	@echo "  codesniffer     - create codesniffer report in 'build/reports' folder"
	@echo "  codesniffer-cli - run codesniffer and display report in console"
	@echo ""
	@echo "Please make sure a 'php' executable is available via PATH environment variable or set a PHP_PATH variable directly with a path like '/usr/bin/php'."
	@echo ""
	@exit 0


composer:

	@echo "[INFO] Installing or updating composer."
	@if [ -e composer.phar ]; then \
		$(PHP) composer.phar self-update; \
	else \
		curl -sS https://getcomposer.org/installer | $(PHP) -d apc.enable_cli=0 -d allow_url_fopen=1 -d date.timezone="Europe/Berlin"; \
	fi


install:

	@make composer
	@echo "[INFO] Installing vendor libraries."
	@$(PHP) -d apc.enable_cli=0 -d allow_url_fopen=1 -d date.timezone="Europe/Berlin" composer.phar install --optimize-autoloader


update:

	@make composer
	@echo "[INFO] Updating vendor libraries."
	@$(PHP) -d apc.enable_cli=0 -d allow_url_fopen=1 -d date.timezone="Europe/Berlin" composer.phar update --optimize-autoloader


tests:

	@make folders
	@$(PHP) vendor/bin/phpunit tests/


code-sniffer:

	@make folders
	-@$(PHP) ./vendor/bin/phpcs --extensions=php --report=checkstyle --report-file=./build/reports/checkstyle.xml --standard=psr2 ./src/


code-sniffer-cli:

	@$(PHP) ./vendor/bin/phpcs -p --report=full --standard=psr2 ./src


scrutinizer:

	@make tests
	@wget https://scrutinizer-ci.com/ocular.phar
	@$(PHP) ocular.phar code-coverage:upload --format=php-clover ./build/logs/clover.xml


folders:

	@mkdir -p ./docs/api
	@mkdir -p ./build/reports
	@mkdir -p ./build/logs
	@mkdir -p ./build/cache


docs:

	@make folders
	@$(PHP) ./vendor/bin/sami.php update ./sami.php


.PHONY: tests docs help composer install update code-sniffer code-sniffer-cli folders scrutinizer

# vim: ts=4:sw=4:noexpandtab:
