#!/bin/bash
# start.sh - Construye y levanta todo el entorno (MariaDB + Backend + Frontend)

set -e

echo ">> Levantando entorno miApp con Docker Compose..."
docker compose up -d --build

echo ">> Esperando a que MariaDB esté saludable..."
until [ "$(docker inspect -f '{{.State.Health.Status}}' miapp_db 2>/dev/null)" == "healthy" ]; do
    printf "."
    sleep 2
done

echo ""
echo ">> Entorno levantado correctamente:"
echo "   - Frontend:  http://localhost:3000"
echo "   - Backend:   http://localhost:8080"
echo "   - MariaDB:   localhost:3306"
docker compose ps
