# Docker setup instructions

1. clone the `MovieRecommendation` repository
2. `docker-compose up -d` - turn the conteners on
3. `docker exec -it movie_web php bin/console doctrine:migrations:migrate` - migrate migrations to create the current state of DB
4. `docker exec -it movie_web php bin/console app:add-movies-from-file` - fill the DB with data of Movies
5. `docker exec -it movie_web php bin/phpunit` - run the unit tests
6. Open swagger site to get more data about routings: `http://localhost:7071/api/docs`


# Env configuration

See created .env.local and fill configuration in that file.
Open `app.config.local.yaml` and fill configuration parameters

All commands execute with: `php bin/console [command]`
- get migrations status: `doctrine:migrations:status --show-versions`
- create new clean migration: `doctrine:migrations:generate`
- run all migrations in queue: `doctrine:migrations:migrate`
- routes list: `debug:router`
- new/update entity: `make:entity`
- rebuild swagger docs: `php bin/console app:compile-docs-file`
- generate crontab for current env: `php bin/console app:cron-tab-generate`
