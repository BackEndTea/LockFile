PHP_CS_FIXER_FUTURE_MODE=1
PHPSTAN=./phpstan.phar
PHP-CS-FIXER=./php-cs-fixer-v2.phar
PHPUNIT=vendor/bin/phpunit
INFECTION=./infection.phar

# URLs to download all tools
PHP-CS-FIXER_URL="https://cs.sensiolabs.org/download/php-cs-fixer-v2.phar"
PHPSTAN_URL="https://github.com/phpstan/phpstan/releases/download/0.10.3/phpstan.phar"
INFECTION_URL="https://github.com/infection/infection/releases/download/0.11.2/infection.phar"

.PHONY: all
#Run all checks, default when running 'make'
all: analyze test

#Non phony targets for phars etc.
vendor: composer.json composer.lock
	composer install

build/cache:
	mkdir -p build/cache

./php-cs-fixer-v2.phar:
	wget $(PHP-CS-FIXER_URL)
	chmod a+x ./php-cs-fixer-v2.phar

./phpstan.phar:
	wget $(PHPSTAN_URL)
	chmod a+x ./phpstan.phar


.PHONY: analyze-ci analyze
analyze-ci: phpstan validate cs-check
analyze: phpstan validate cs-fix

.PHONY: cs-fix cs-check phpstan validate infection test
cs-fix: build/cache $(PHP-CS-FIXER)
	$(PHP-CS-FIXER) fix -v --cache-file=build/cache/.php_cs.cache

cs-check: build/cache $(PHP-CS-FIXER)
	$(PHP-CS-FIXER) fix -v --cache-file=build/cache/.php_cs.cache --dry-run --stop-on-violation

phpstan: vendor $(PHPSTAN)
	$(PHPSTAN) analyse src tests --level=max --no-interaction

validate:
	composer validate --strict

./infection.phar:
	wget $(INFECTION_URL)
	chmod a+x ./infection.phar

test:
	vendor/bin/phpunit

infection: $(INFECTION)
	$(INFECTION) --threads=4 --min-covered-msi=100 --min-msi=90
