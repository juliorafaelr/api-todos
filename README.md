# Dockerized simple todos API

## Project setup

The API was build in [Laravel framework](https://laravel.com/ "Laravel framework") v9,
using [JSONAPI standard](https://jsonapi.org/ "JSONAPI standard")

### Deployment

if you want to run the API as stand-alone for dev purposes:

1. clone the repo this repo on production server
2. set ``.env``.
3. run ``cd api-todos && docker compose up -d --build``

## Notes

after deployment you will get an error ``401 unauthorized.`` when visiting the app. that's because there's no users on
the database.

you will need to create 1 user using the ``create user endpoint``, then use the returned token on your api calls

## Structure

this project was build in Vue.js and is intended to:

- how to build a JSONAPI backend build up with proper security.
- CSRF and CORS Configuration built-in on ``config/cors.php``, ``config/sanctum.php``
- SQL injection proof powered by [Eloquent ORM](https://laravel.com/docs/9.x/eloquent "Eloquent ORM").

it lacks of users Read Update and Delete endpoints

it has the regular Laravel structure + [Laravel JSON API](https://laraveljsonapi.io/docs/2.0/ "Laravel JSON API").

## Endpoint and Usage

the base url of the API ``<domain>/api/v1/``

### API endpoints

| function    | endpoint                     | parameters                               | Request headers                                                                                                               |
|-------------|------------------------------|------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------|
| List tasks  | GET api/v1/tasks/            |                                          | ``Accept: application/vnd.api+json`` <br/> ``Authorization: Bearer <token>``                                                  |
| Get task    | GET api/v1/tasks/<taskId>    |                                          | ``Accept: application/vnd.api+json`` <br/> ``Authorization: Bearer <token>``                                                  |
| Create task | POST api/v1/tasks/           | json body with ``Task Entity structure`` | ``Accept: application/vnd.api+json`` <br/> ``Content-Type: application/vnd.api+json`` <br/> ``Authorization: Bearer <token>`` |
| Update task | PATCH api/v1/tasks/<taskId>  | json body with ``Task Entity structure`` | ``Accept: application/vnd.api+json`` <br/> ``Content-Type: application/vnd.api+json`` <br/> ``Authorization: Bearer <token>`` |
| Delete task | DELETE api/v1/tasks/<taskId> |                                          | ``Accept: application/vnd.api+json`` <br/> ``Authorization: Bearer <token>``                                                  |
| Create User | POST api/v1/users/           | json body with ``User Entity structure`` | ``Accept: application/vnd.api+json`` <br/> ``Content-Type: application/vnd.api+json``                                         |

### Entities structure

### - Tasks

```
{
 	"data": {
 		"type": "tasks",
 		"id": sting (hash, auto generated on create)
 		"attributes": {
 			"text": string,
 			"day": string,
 			"done": boolean,
 			"created_at": timestamp (read only),
 			"updated_at": timestamp (read only)
 		}
 	}
 }
```

#### Example call

```
POST https://<domain>/api/v1/tasks HTTP/1.1
Authorization: Bearer <token>
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json

{
 	"data": {
 		"type": "tasks",
 		"attributes": {
 			"text": "some task",
 			"day": "May 23rd",
 			"done": false
 		}
 	}
 }
```

### - Users

```
{
 	"data": {
 		"type": "users",
 		"id": int (auto generated on create),
 		"attributes": {
 			"name": string,
 			"email": string,
 			"password": string,
 			"created_at": timestamp (read only),
 			"updated_at": timestamp (read only),
 			"email_verified_at": timestamp,
 			"remember_token": string
 		}
 	}
 }
```

#### example call

```
POST https://<domain>/api/v1/users HTTP/1.1
Accept: application/vnd.api+json
Content-Type: application/vnd.api+json

{
 	"data": {
 		"type": "users",
 		"attributes": {
 			"name": "John Doe",
 			"email": "john.doe@example.com",
 			"password": "password",
 		}
 	}
 }
```

## Unit Tests

unit tests live in ``api-todos/tests/Unit`` to run them just
execute ``docker compose run api php artisan test --parallel --recreate-databases``
