# Sellers commissions

**Full stack developer technical test**

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
- [API: 0.0.0.0:3333](http://0.0.0.0:3333/tasks)

API Documentation:
[POSTMAN](https://documenter.getpostman.com/view/2210616/S11HuJvj)


### Stop
Run

```bash
docker-compose stop
```

in the docker-compose.yml directory.