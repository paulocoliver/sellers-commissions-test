# Sellers commissions

## Dependencies: 

[Docker](https://www.docker.com/get-started) :)


## Setup

To up the server run

```bash
docker-compose up --build -d
```

in the docker-compose.yml directory.


### Migrations

Run the following command to run startup migrations.

```bash
docker-compose exec php php artisan migrate
```

### Play

- [Angular: 0.0.0.0:3000](http://0.0.0.0:3000)
- [API Node: 0.0.0.0:3333](http://0.0.0.0:3333/tasks)

API Resources:
- List:   GET     http://0.0.0.0:3333/tasks
- Show:   GET     http://0.0.0.0:3333/tasks/{id}
- Create: POST    http://0.0.0.0:3333/tasks
- Update: PUT     http://0.0.0.0:3333/tasks/{id}
- Delete: DELETE  http://0.0.0.0:3333/tasks/{id}

### Stop
Run

```bash
docker-compose stop
```

in the docker-compose.yml directory.