# Backend Let's play!!

![Discord Logo](https://lapublicidad.net/wp-content/uploads/2021/04/discord-803x420.jpeg))

## Tabla de contenidos

- [Backend Let's play!!](#backend-lets-play)
  - [Tabla de contenidos](#tabla-de-contenidos)
- [Stack tecnol贸gico 馃洜](#stack-tecnol贸gico-)
- [Descripci贸n del proyecto 馃搵](#descripci贸n-del-proyecto-)
- [Relaciones 馃エ](#relaciones-)
- [Endpoints 鉀(#endpoints-)
  - [Users](#users)
  - [Games](#games)
  - [Parties](#parties)
  - [Messages](#messages)
- [Variables de entorno](#variables-de-entorno)
- [Base de datos 馃敆](#base-de-datos-)
- [Comenzar a utilizar el repositorio 馃憖](#comenzar-a-utilizar-el-repositorio-)
- [Instalaci贸n 馃シ](#instalaci贸n-)
- [Tareas pendientes 馃](#tareas-pendientes-)
- [Autor 馃](#autor-)
- [Aportar al proyecto 馃グ](#aportar-al-proyecto-)
- [Agradecimientos 馃挅](#agradecimientos-)

# Stack tecnol贸gico 馃洜

Se han utilizado las siguientes tecnolog铆as:

<p align="left">

<a href="https://git-scm.com/" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="git" width="40" height="40"/> </a>
<a href="https://heroku.com" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/heroku/heroku-icon.svg" alt="heroku" width="40" height="40"/> </a>
<a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img height="50" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/mysql/mysql.png"> </a>
<a href="https://postman.com" target="_blank" rel="noreferrer"> <img src="https://www.vectorlogo.zone/logos/getpostman/getpostman-icon.svg" alt="postman" width="40" height="40"/> </a>

  <p align="left"> <a href="https://laravel.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a>  </p>
  
</p>

# Descripci贸n del proyecto 馃搵

Heroku Url: https://letsplay1.herokuapp.com/

Proyecto del bootcamp en GeeksHubs d贸nde nos piden que realicemos el backend de una web app d贸nde los jugadores pueden crear salas de videojuegos con el fin de chatear con otros jugadores que quieran jugar, unirse a otras salas ya creadas, escribir mensajes...
A continuaci贸n cito los objetivos MVP del proyecto:

-   Los usuarios se tienen que poder registrar a la aplicaci贸n, estableciendo un usuario/contrase帽a.
-   Los usuarios tienen que autenticarse a la aplicaci贸n haciendo login.
-   Los usuarios tienen que poder crear Partidas (parties) para un determinado videojuego.
-   Los usuarios tienen que poder buscar Partidas seleccionando un videojuego.
-   Los usuarios pueden entrar y salir de una Party.
-   Los usuarios tienen que poder enviar mensajes a la Party. Estos mensajes tienen que poder ser editados y borrados por su el usuario que lo ha creado.
-   Los mensajes que existan en una Party se tienen que visualizar como un chat com煤n.
-   Los usuarios pueden introducir y modificar sus datos de perfil.
-   Los usuarios tienen que poder hacer logout de la aplicaci贸n web.

He realizado 4 entidades referenciadas como Users, Games, Parties, Messages y una tabla intermedia entre Parties y Users para realizar la relacion N:M entre estas dos entidades.

-   Tabla `Users`:  
    Contiene los datos necesarios de los jugadores para registrarse en el sistema, que est谩 relacionada con Games, Parties y Messages.
-   Tabla `Games`:
    Esta tabla contiene el nombre del videojuego al que se realiza la b煤squeda de partidas, y est谩 creado por un usuario, por eso tiene la relaci贸n 1:N con los usuarios, ya que estos son los que crean los juegos.
-   Tabla `Parties`:
    Contiene la informaci贸n sobre las salas o "Parties", que es d贸nde se mezclan todas las entidades, d贸nde los users pueden unirse o dejar la party que contiene un videojuego, escribir, editar y borrar mensajes, y visualizar los mensajes de otros players que esten unidos a la misma. Parties tiene una relacion N:M con Users, por lo que se genera la tabla intermedia con las for谩neas correspondientes, party_user.
-   Tabla `Messages`:
    Esta tabla contiene los mensajes que crean los usuarios, contiene la clave for谩nea de Users y de Parties, solo pueden crear y visualizar mensajes los usuarios que est茅n unidos a esa party, adem谩s s贸lo podr谩n editar o borrar mensajes aquel usuario que los haya creado.

    ![relaciones.png](app/Images/relaciones.png)

# Relaciones 馃エ

Las relaciones entre las tablas son las siguientes:

```
- Users vs Games 1:N
- Users vs Parties 1:N
- Users vs Parties N:M
- Users vs Messages 1:N
- Games vs Parties 1:N
- Parties vs Messages 1:N
```

# Endpoints 鉀?

Estos son los endpoints de cada entidad y su modelo json para utilizarlos con `Postman`:

## Users

```json
{
    "name": "userName",
    "email": "userEmail@userDomain.com",
    "password": "userPassword",
    "alias": "userAlias"
}
```

-   Post('/register', [AuthController::class, 'register']); Introduciento el JSON modelo de arriba puedes registrarte.
-   Post('/login', [AuthController::class, 'login']); Introduciendo el email y la password en el body te devuelve un token.

```
{
  "email": "userEmail@userDomain.com",
  "password": "userPassword",
}
```

-   Get('/profile', [AuthController::class, 'profile']); Devuelve los datos del perfil del usuario que est谩 logeado.
-   Get('/logout', [AuthController::class, 'logout']); Desconecta al usuario de la aplicaci贸n, dando de baja su token, que ha de ser introducido en el body.

-   CRUD completo de User:
    -   post('/users'...), crea un nuevo usuario.
    -   get('/users/{id}'...), muestra la informaci贸n del usuario logeado.
    -   get('/users'...), muestra la informaci贸n de los usuarios.
    -   put('/users/{id}'...) actualiza la informaci贸n del usuario logeado.
    -   delete('/users/{id}'...) elimina al usuario indicado.

## Games

```json
{
    "title": "Game Example"
}
```

-   CRUD completo de Games:
    -   post('/ugame'...), crea un nuevo juego.
    -   get('/game/{id}'...), muestra la informaci贸n del juego indicado en los params.
    -   get('/game'...), muestra la informaci贸n de los juegos.
    -   get('/game/title/{title}'...), muestra la informaci贸n por el t铆tulo de un juego.
    -   put('/game/{id}'...) actualiza la informaci贸n de un juego.
    -   delete('/game/{id}'...) elimina un juego.

## Parties

```json
{
    "name": "PartyName",
    "game_id": 2 -> example game_id
}
```

-   CRUD completo de Party:
    -   post('/party'...), crea una nueva party.
    -   get('/party/{id}'...), muestra la informaci贸n de una party en concreto.
    -   get('/parties'...), muestra la informaci贸n de todas las parties que hay creadas.
    -   put('/party/{id}'...) actualiza la informaci贸n de la party indicada.
    -   delete('/party/{id}'...) elimina la party indicada.
    -
    -   post('/partyUser'...), asocia al usuario a una party para que pueda crear mensajes en ella.
    -   get('/partyUser/{id}'...), muestra la informaci贸n de una party-user en concreto.
    -   post('/leavePartyUser'...), elimina al usuario de una party.

## Messages

```json
{
    "message": "驴Message example?",
    "party_id": 7 <- ejemplo de partyId
}
```

-   CRUD completo de Message:
    -   post('/message/{id}'...), crea un nuevo mensaje en la party indicada por el id.
    -   get('/message/{id}'...), muestra los mensajes del usuario logeado en una party en concreto.
    -   get('/message'...), muestra todos los mensajes del usuario logeado.
    -   put('/message/{id}'...) actualiza el mensaje indicado con el id, solo el usuario que lo cre贸 puede hacerlo.
    -   delete('/message/{id}'...) elimina el mensaje indicado, solo el usuario que lo cre贸 puede hacerlo.

# Variables de entorno

Variables de entorno modificadas:

```
DB_PORT=3306
DB_DATABASE=api_PHP_laravel
DB_USERNAME=[usuario propio]
DB_PASSWORD=[password propia]
LOG_CHANNEL=daily
JWT_SECRET=[ExampleSecretKey]
```

# Base de datos 馃敆

Se ha utilizado Eloquent como ORM para interactuar con la base de datos de Mysql, puesto que he utilizado Laravel ya viene integrado por defecto en el framework.

# Comenzar a utilizar el repositorio 馃憖

Lo primero que se debe realizar son las migraciones para generar las tablas en nuestra base de datos con el siguiente comando:
`php artisan migrate`

Este comando ejecutara las siguientes migraciones, con sus respectivas claves for谩neas:

-   Creaci贸n de tabla usuarios
-   Creaci贸n de tabla games
-   Creaci贸n de tabla parties
-   Creaci贸n de tabla intermedia users_parties
-   Creaci贸n de tabla messages

Adem谩s puedes utilizar el siguiente comando para ejecutar los siguientes Seeders para poblar la BD:
`php artisan db:seed`

Con este comando se crear谩n 5 usuarios, 5 games y 5 parties, tras ello a trav茅s de postman se ha de realizar una party_user y comenzar a generar mensajes en ella.

# Instalaci贸n 馃シ

Para poder consumir el backend es necesario lo siguiente:

-   Clonar o forkear el repositorio si deseas, _(https://github.com/dvdsanar/api_PHP_laravel)_.
-   Instalar Composer: `https://getcomposer.org/download/`
-   Hacer _composer install_ para cargar las dependencias del composer.json
-   Atacar al API publicada en https://letsplay1.herokuapp.com/ o como localhost si lo prefieres (es necesario cambiarlo en el .env)
-   Es necesario utilizar Postman para probar el Api ya que carece de Frontend.
-   Conexi贸n a internet

# Tareas pendientes 馃

-   [ ] Crear un FrontEnd para la API
-   [ ] Crear roles y su middleware para ver si los usuarios est谩n activos.

# Autor 馃

-   El autor de este proyecto es David S谩nchez Ariza.

# Aportar al proyecto 馃グ

-   Si deseas colaborar con 茅ste proyecto u otro no dudes en contactar conmigo o solicitar una pull request.
-   Cualquier aporte siempre ser谩 bienvenido.

# Agradecimientos 馃挅

-   A nuestro profesor Dani Tarazona, por su paciencia y su dedicaci贸n.
-   A todos mis compa帽eros que me han ayudado con el proyecto.
