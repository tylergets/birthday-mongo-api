# MongoDB + Lumen Example

This is a tiny example of using MongoDB + Lumen together to store a person and their birthday.

## General Notes

For ease of running the project, I have included the .env in the repository; this would normally be left out.

Main points of interests will be:

[BirthdayCalculatorTest.php](https://github.com/tylergets/birthday-mongo-api/blob/master/tests/BirthdayCalculatorTest.php)
[BirthdayCalculator.php](https://github.com/tylergets/birthday-mongo-api/blob/master/app/Services/BirthdayCalculator.php)
[PeopleController.php](https://github.com/tylergets/birthday-mongo-api/blob/master/app/Http/Controllers/PeopleController.php)
[Person.php](https://github.com/tylergets/birthday-mongo-api/blob/master/app/Models/Person.php)

There were no dependencies added besides MongoDB Eloquent Provider

## Details

A Dockerfile is provided to provide the MongoDB extension to the php:8 image

## Running The Project

```shell
docker-compose up
```

### Running Tests

Start the project as above, then run the following command:

```shell
docker exec -it api ./vendor/bin/phpunit
```

### Improvements

This project is very bare bones; it could be improved in a few ways:

 * Distribution - Currently the built in PHP web server is being used, this is not suitable for a production deployment. Depending on the deployment, a new docker container should be created with a webserver base.
