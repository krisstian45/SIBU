# ===== SIBU ======

Sistema para Buffet nos permite la administración de compra y pedidos de productos del Buffet de Informática.
Permite tener un control de stock de productos, obtener balances e ingresos y un manejo online de pedidos.

## Empecemos
Estas instrucciones brindarán una copia funcional del proyecto SIBU en tu sistema local. 

## Requisitos
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

## Instalación
Paso 1) Para correr el entorno de desarrollo, primero debemos configurar el archivo
app/config/databases.php (Reemplazamos XXXXX).

```
...
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'XXXXX'),
            'username'  => env('DB_USERNAME', 'XXXXX'),
            'password'  => env('DB_PASSWORD', 'XXXXX'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
...
```
 

Paso 2) Creamos la BD:

```
mysql -u root -e "create database grupo46"; 
```

Paso 3) Importar la BD brindada (grupo46.sql).
Ingresamos a la consola e ingresamos:
```
mysql -u root -p grupo46 < final/grupo46.sql 
```
Para importar la base debemos colocar el path donde se encuentra grupo46.sql.

La base de datos brindada ya posee categorias, productos y usuarios para ser usados de prueba.
