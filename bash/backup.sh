#!/bin/bash
# backup.sh - Genera un respaldo (dump) de la base de datos bd_ventas

set -e

BACKUP_DIR="./backups"
FECHA=$(date +"%Y%m%d_%H%M%S")
ARCHIVO="$BACKUP_DIR/bd_ventas_$FECHA.sql"

mkdir -p "$BACKUP_DIR"

echo ">> Generando respaldo de la base de datos bd_ventas..."
docker exec miapp_db sh -c 'exec mariadb-dump -u ventas_user -p"ventas_pass" bd_ventas' > "$ARCHIVO"
