# Shorten-url API

### About project

For this project the main concern was to keep simplicity and clarity.
This project was implemented in TDD method. but not fully tested (due to lack of time).
this project has been run on docker-container provided by Laravel sail.

### Before running project
please consider follwoing ENV vars before project setup:
> FORWARD_DB_PORT //to address the db port
> APP_PORT //to address the port for endpoint
> DB_CONNECTION=mysql
> DB_HOST=mysql
> DB_PORT=3306
> FORWARD_DB_PORT=3399
> DB_DATABASE=url_shortener
> DB_USERNAME=sail
> DB_PASSWORD=password

### To run Project

Enter the project folder and run following commands:
```sh
$ cd url-shortener
$ ./vendor/bin/sail up -d
$ composer install
$ php artisan migrate
```
### To run tests

```sh
./vendor/bin/sail artisan test
```

# Api endpoints
Endpoins are designed based on an assumed scenario which starts from saving and serving a given url.

#### 1- Save url

```sh
$ [POST] /api/v1/url 
body prams example:
{
    "url" : "https://www.givenurl.test"
}
```
#### 2- get url data

```sh
$ [GET] /api/v1/url/{uuid}
```

> it reutns all data related to url including hit_count

#### 3- update url

```sh
$ [PUT] /api/v1/url/{uuid}
 body prams example:
{
    "redirect_url" : "https://www.givenurl.test",
    "active": true
}
```
> note that for the scope of this project only redirect_url and active paraments are update
> hit_count is not going to be updated via this route

#### 4 - redirect to url (it redirects to url based on given uuid)
```sh
$ [GET] /{uuid}
```
> note: this route will automatically increase hit_count by 1
