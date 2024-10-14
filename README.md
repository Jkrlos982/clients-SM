# Proyecto Laravel: Gestión de Clientes

Este proyecto es una aplicación de gestión de clientes desarrollada en Laravel y Docker.

## Requisitos

- Docker
- Docker Compose
- Composer

## Clonar el repositorio

Para clonar el repositorio en tu máquina local, ejecuta:

```bash
git clone https://github.com/Jkrlos982/clients-SM.git
cd clients-SM.git
```

## Iniciar los contenedores de Docker

```bash
docker-compose up --build
```

## Ejecutar las migraciones y seeds

### Migraciones

Después de que los contenedores estén en funcionamiento, ejecuta las migraciones para preparar la base de datos:

```bash
docker-compose exec app php artisan migrate
```

### Seeds

Luego, ejecuta los seeds para llenar la base de datos con datos de prueba:

```bash
docker-compose exec app php artisan db:seed
```

## Acceder a la aplicación web y a la base de datos

Antes de acceder a la aplicacion es necesario ejecutar el siguiente comando para hacer el build de los estilos:

```bash
npm run dev
```

### Aplicación web

Puedes acceder a la aplicación web en tu navegador utilizando la siguiente URL:

```bash
http://localhost:8080
```

### Base de datos

Para conectarte a la base de datos desde un cliente de SQL, puedes usar las siguientes credenciales:

- Host: localhost
- Puerto: 3307
- Usuario: root
- Contraseña: root
- Base de datos: clients

## Comandos útiles

### Bajar los contenedores

Para detener y eliminar los contenedores:

```bash
docker-compose down
```

### Acceder al contenedor de la aplicación

Para acceder a la terminal dentro del contenedor de la aplicación:

```bash
docker-compose exec app bash
```

### Ejecutar pruebas

Para ejecutar las pruebas unitarias de Laravel:

```bash
docker-compose exec app php artisan test
```
Si solo se quiere probar el controlador ClientController entonces se debe ejecutar:

```bash
docker-compose exec app php artisan test --filter=ClientControllerTest
```
