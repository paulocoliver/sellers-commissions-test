# Sellers commissions

**Full stack developer technical test**

**Made with [Laravel5.7](https://laravel.com/docs/5.7) (PHP7.2) and [Angular7](https://angular.io/docs)**

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

Front:
- [Angular: 0.0.0.0:3000](http://0.0.0.0:3000)

API:
- [API: 0.0.0.0:3333](http://0.0.0.0:3333/api/sellers)
- [Documentation - POSTMAN](https://documenter.getpostman.com/view/2210616/S11HuJvj)

Mail Test: Sales Of The Day
- [In the browser](http://0.0.0.0:3333/test-mail)
- Console, run the following command
  ```bash
  docker-compose exec php php artisan email:send
  ``` 
  now check the log folder "/api/storage/logs".
- Configure the schedule, add the following Cron entry to your server:
  ```bash
  docker-compose exec php php artisan schedule:run
  ```
  the email will be sent every day at 23:59.

### Stop
Run

```bash
docker-compose stop
```

in the docker-compose.yml directory.
