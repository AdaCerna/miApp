# miApp

Entorno de desarrollo completo con **Docker Compose**: MariaDB + API REST en PHP
(Apache) + Frontend en React (Node.js/Vite).

## Estructura

```
miApp/
├── backend/          # API REST en PHP (Apache)
│   ├── db/init.sql   # Script de creación de bd_ventas y tabla usuarios
│   ├── src/           # Código fuente PHP
│   └── Dockerfile
├── frontend/          # SPA en React (Vite)
│   ├── src/
│   └── Dockerfile
├── bash/               # Scripts de automatización
│   ├── start.sh        # Levanta todo el entorno
│   ├── backup.sh        # Respalda la base de datos
│   ├── logs.sh          # Muestra logs de los contenedores
│   └── stop.sh           # Detiene el entorno
├── docker-compose.yml
└── README.md
```

## Requisitos

- Docker y Docker Compose instalados en el servidor Ubuntu.
- No se instala Apache, PHP, Node.js ni MariaDB directamente sobre el sistema
  operativo: todo corre en contenedores.

## Cómo levantar el entorno

```bash
cd miApp
./bash/start.sh
```

Esto construye las imágenes y levanta 3 contenedores:

| Servicio  | URL                          | Descripción              |
|-----------|-------------------------------|---------------------------|
| Frontend  | http://localhost:3000          | Interfaz React             |
| Backend   | http://localhost:8080/api/usuarios.php | API REST en JSON  |
| MariaDB   | localhost:3306                 | Base de datos bd_ventas    |

## Base de datos

Base: `bd_ventas`
Tabla: `usuarios` (id, nombre, apePaterno, apeMaterno, user, password, estado)

El script `backend/db/init.sql` se ejecuta automáticamente la primera vez que
se crea el volumen de MariaDB.

## API REST (usuarios.php)

| Método | Endpoint                        | Acción             |
|--------|----------------------------------|--------------------|
| GET    | /api/usuarios.php                 | Listar usuarios     |
| GET    | /api/usuarios.php?id=1            | Obtener un usuario   |
| POST   | /api/usuarios.php                 | Registrar usuario     |
| PUT    | /api/usuarios.php?id=1            | Actualizar usuario     |
| DELETE | /api/usuarios.php?id=1            | Eliminar usuario        |

Toda la comunicación es en formato JSON.

## Scripts Bash

- `./bash/start.sh` – construye y levanta todo el entorno.
- `./bash/backup.sh` – genera un dump de bd_ventas en `./backups/`.
- `./bash/logs.sh [servicio]` – muestra logs de todos los servicios o de uno específico.
- `./bash/stop.sh [--clean]` – detiene el entorno (con `--clean` también borra los datos).

## Desarrollo

El desarrollo se realizó mediante **Visual Studio Code** con la extensión
**Remote - SSH**, conectado directamente al servidor Ubuntu.

## Git y GitHub

```bash
git init
git add .
git commit -m "Primer commit: estructura inicial del proyecto"
git branch -M main
git remote add origin <URL_DE_TU_REPOSITORIO>
git push -u origin main
```

## Autor

Trabajo realizado para el curso de Desarrollo de Soluciones Cloud.
Profesor: Ing. Roger Saul Barreto Minaya.
