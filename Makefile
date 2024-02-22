dsu-f:
	docker compose exec php bin/console doctrine:schema:update --force && \
	echo "Database has been updated. End of make."; 

dsu-d:
	docker compose exec php bin/console doctrine:schema:update --dump-sql 2>/dev/null && \
	read -p "Voulez-vous forcer l'update? (y/N) " response && \
	if [ "$$response" = "y" ] || [ "$$response" = "Y" ] || [ "$$response" = "o" ] || [ "$$response" = "O" ]; then \
		docker compose exec php bin/console doctrine:schema:update --force 2>/dev/null; \
		echo "Database has been updated. End of make."; \
	else \
		echo "Nothing has been updated. End of make."; \
	fi

cc:
	docker compose exec php bin/console cache:clear

gp:
	git reset --hard origin/develop && \
	git pull && \
	bin/console c:cl && \
	npm run build && \
	cd .. && chmod -R 777 PhotoGodard


dcu:
	docker compose up --build --force-recreate -d

install: 
	make dcu && \
	docker compose exec php composer install && \
	docker compose exec php bin/console d:d:c && \
	make dsu-f && \
	docker compose exec php bin/console d:f:l -n && \
	docker compose exec php bin/console liip:imagine:cache:resolve assets/images/image1.jpg