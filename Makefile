APP=docker-compose exec -T php
TOOLS=docker-compose run --rm tools
CONSOLE=$(APP) bin/console

start:          ## Start the Docker containers
	docker-compose up -d

stop:           ## Stop the Docker containers
	docker-compose down

composer:       ## Install the project PHP dependencies
	$(APP) composer install

db-create:      ## Create the database and load the fixtures in it
	$(APP) php -r "for(;;){if(@fsockopen('db',3306)){break;}}" # Wait for MariaDB
	$(CONSOLE) doctrine:database:drop --force --if-exists
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:schema:create

db-fixtures:    ## Reloads the data fixtures for the dev environment
	$(CONSOLE) doctrine:fixtures:load -n

db-update:      ## Update the database structure according to the last changes
	$(CONSOLE) doctrine:schema:update --force

clear-cache:    ## Clear the application cache in development
	$(CONSOLE) cache:clear

clear-all:      ## Deeply clean the application (remove all the cache, the logs, the sessions and the built assets)
	$(CONSOLE) cache:clear --no-warmup
	$(CONSOLE) cache:clear --no-warmup --env=prod
	$(CONSOLE) cache:clear --no-warmup --env=test
	$(APP) rm -rf var/logs/*
	$(APP) rm -rf var/sessions/*
	$(APP) rm -rf web/built
	$(APP) rm -rf supervisord.log supervisord.pid npm-debug.log .tmp

clean:         ## Removes all generated files
	- @make clear-all
	$(APP) rm -rf vendor node_modules

perm:           ## Fix the application cache and logs permissions
	$(APP) chmod 777 -R var
	$(APP) chmod 777 -R logs
	$(APP) chmod 777 -R web/images

test-php:       ## Run the PHP tests
	$(APP) vendor/bin/phpunit

import-tracks:    ## Import tracks
	$(CONSOLE) app:import-tracks ./files/


elastica-populate:    ## populates elastic indexes
	$(CONSOLE) fos:elastica:populate -vv
