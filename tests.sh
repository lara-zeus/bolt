#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# Define the database types based on your folder structure
DATABASES=("sqlite" "mysql" "pgsql")

for DB in "${DATABASES[@]}"
do
    echo "-------------------------------------------------------"
    echo "Running tests for: $DB"
    echo "-------------------------------------------------------"

    COMPOSE_FILE="docker/$DB/compose.yaml"

    docker compose -f "$COMPOSE_FILE" build

    docker compose -f "$COMPOSE_FILE" up \
        --abort-on-container-exit \
        --exit-code-from bolt
done

echo "OK"
