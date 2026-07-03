#!/bin/bash
# logs.sh - Muestra los logs en vivo de todos los servicios,
# o de uno solo si se indica como argumento: ./logs.sh backend

set -e

if [ -z "$1" ]; then
    echo ">> Mostrando logs de todos los servicios (Ctrl+C para salir)..."
    docker compose logs -f
else
    echo ">> Mostrando logs del servicio: $1 (Ctrl+C para salir)..."
    docker compose logs -f "$1"
fi
