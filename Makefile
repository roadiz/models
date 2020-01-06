test:
	vendor/bin/phpunit -v --bootstrap=tests/bootstrap.php --whitelist ./src --coverage-clover ./build/logs/clover.xml tests/
	vendor/bin/phpcbf --report=full --report-file=./report.txt --extensions=php --warning-severity=0 --standard=PSR2 -p ./src
	vendor/bin/phpstan analyse -c phpstan.neon -l 3 src

phpcs:
	vendor/bin/phpcs --report=full --report-file=./report.txt --extensions=php --warning-severity=0 --standard=PSR2 -p ./src

phpcbf:
	vendor/bin/phpcbf --report=full --report-file=./report.txt --extensions=php --warning-severity=0 --standard=PSR2 -p ./src
