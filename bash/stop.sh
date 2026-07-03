#!/bin/bash
# stop.sh - Detiene los contenedores. Con --clean también borra volúmenes (datos de la BD)

set -e

if [ "$1" == "--clean" ]; then
    echo ">> Deteniendo contenedores y eliminando volúmenes (se perderán los datos)..."
    docker compose down -v
else
    echo ">> Deteniendo contenedores (los datos de la BD se conservan)..."
    docker compose down
fi
