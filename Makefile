.PHONY: test

lint:
	php -l src/API.php
	php -l src/Application.php
	php -l src/IVR.php

test:
	make lint
	make cover

cover:
	./vendor/bin/phpunit --coverage-clover coverage/lcov.info --coverage-html coverage/index.html

sonar:
		sed '/sonar.projectVersion/d' ./sonar-project.properties > tmp && mv tmp sonar-project.properties
		echo sonar.projectVersion=`cat package.json | python -c "import json,sys;obj=json.load(sys.stdin);print obj['version'];"` >> sonar-project.properties
		wget https://s3.eu-central-1.amazonaws.com/dialonce-cdn/utilities/sonar-scanner-cli.zip
		unzip sonar-scanner-*
ifdef CIRCLE_PULL_REQUEST
		@sonar-scanner/bin/sonar-scanner -e -Dsonar.analysis.mode=preview -Dsonar.github.pullRequest=${shell basename $(CIRCLE_PULL_REQUEST)} -Dsonar.github.repository=$(REPO_SLUG) -Dsonar.github.oauth=$(GITHUB_TOKEN) -Dsonar.login=$(SONAR_LOGIN) -Dsonar.password=$(SONAR_PASS) -Dsonar.host.url=$(SONAR_HOST_URL)
endif
ifeq ($(CIRCLE_BRANCH),develop)
		@sonar-scanner/bin/sonar-scanner -e -Dsonar.analysis.mode=publish -Dsonar.host.url=$(SONAR_HOST_URL) -Dsonar.login=$(SONAR_LOGIN) -Dsonar.password=$(SONAR_PASS)
endif
		rm -rf sonar-scanner*
