# BullyingAPI
Aplicación que permitirá guardar un listado de usuarios y puntuaciones(Negativas). Esta aplicación; solo es de demostración. Esta realizada en el Master de Ingeniería Informática de la Universidad de Almería.

## Instalación

Esta aplicación esta creada con PHP con un gestor de base de datos Mysql. Esta aplicación utiliza ```composer``` para la gestión de dependencias. Seguidamente vamos a mostrar como instalar esta aplicación en un servidor para poder ejecutarlo.

En primer lugar, descargamos el código, usando GIT:

```bash
git clone https://github.com/zerasul/BullyingAPI.git
```

Una vez descargado, vamos a usar _composer_ para descargar las dependencias.

```php
php composer.phar install
```
Para descargar e instalar composer puede verlo en el siguiente [enlace](https://getcomposer.org/doc/00-intro.md).

Una vez descargado, verá una nueva carpeta llamada ```vendor```. Con el código ya listo, vamos a crear la base de datos; en este caso el programa está preparado para MYSQL; pero puede cambiarse el código para cualquier otro gestor de base de datos. En la carpeta ```sql``` encontrará el script para crear la estructura de la base de datos. Una vez creada la base de datos, vamos a configurar la conexión a esta. 

Para configurar la conexión a la base de datos, modificaremos los parámetros en el fichero ```conf/dbconf.php```.

```php
  $db['db']='<database>';
	$db['user']='<user>';
	$db['password']='<password>';
	$db['host']='<db_address>';
	$db['port']=3306;
```

Modificaremos en cada caso los parámetros para nuestra conexión.

## Uso

Esta aplicación, crea un Web Service REST que nos permite obtener el ranking de puntuación de cada usuario y permite también darle votos a cada integrante. En este apartado se explica como utilizar esta API REST.

### Obtener Ranking

Esta operación, nos permite obtener el ranking por puntuación de mayor a menor.

- dirección: <dirección al proyecto>/index.php/hola
- método: GET
- parámetros: Ninguno.
- Devuelve: Array en JSON, con el ranking de usuarios. Cada usuario tiene: identificador, nombre, puntuación y hash para poder crear el avatar via [gravatar](http://gravatar.com).

### Insertar Voto

Esta operación, inserta 1 voto al correspondiente usuario:

- dirección: <dirección al proyecto>/index.php/hola
- método: POST.
- Parámetros: idusuario: identificador del usuario que recibe el punto(obligatorio).
- devuelve: Array en JSON, que contiene el identificador del usuario y la puntuación actual.

Con estas últimas instrucciones el usuario puede ejecutar el proyecto para demostración.

**NOTA**: Esta aplicación es solo con fines demostrativos; no tiene que ver nada con el Bullying Escolar.
