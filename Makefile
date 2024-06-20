PHPUNIT = vendor/bin/phpunit -c phpunit.xml

help:
	@echo ""
	@echo "Please use 'make <target>' where <target> is one of:"
	@echo ""
	@echo "  test          to perform all tests"
	@echo "  unit          to perform unit tests"
	@echo "  integration   to perform integration tests"
	@echo "  validators    to perform validators tests"
	@echo "  transformers  to perform transformers tests"
	@echo "  clear         to clear PHPUnit tests cache"

test:
	${PHPUNIT} --testsuite=default

unit:
	${PHPUNIT} --testsuite=unit

integration:
	${PHPUNIT} --testsuite=integration

validators:
	${PHPUNIT} --testsuite=default --group=Validators

transformers:
	${PHPUNIT} --testsuite=default --group=Transformers

clear:
	rm -rf tests/cache
