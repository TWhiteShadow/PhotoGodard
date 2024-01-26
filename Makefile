dsu-f:
	docker compose exec symfony php bin/console doctrine:schema:update --force && \
	echo "Database has been updated. End of make."; 

dsu-d:
	docker compose exec symfony php bin/console doctrine:schema:update --dump-sql 2>/dev/null && \
	read -p "Voulez-vous forcer l'update? (y/N) " response && \
	if [ "$$response" = "y" ] || [ "$$response" = "Y" ] || [ "$$response" = "o" ] || [ "$$response" = "O" ]; then \
		docker compose exec symfony php bin/console doctrine:schema:update --force 2>/dev/null; \
		echo "Database has been updated. End of make."; \
	else \
		echo "Nothing has been updated. End of make."; \
	fi

cc:
	docker compose exec symfony php bin/console cache:clear

gp:
	git pull && \
	bin/console c:cl && \
	npm run build
