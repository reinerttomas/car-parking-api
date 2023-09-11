# Car Parking API - Laravel Demo Application

This is a simple Laravel demo application for managing car parking. It provides a basic API for CRUD (Create, Read, Update, Delete) operations.

## Stack

Includes services for a web server (Caddy), PHP, and a MariaDB database. This configuration is suitable for deploying web applications, particularly those built with PHP frameworks like Laravel or Symfony.
* Caddy
* PHP-FPM (8.2+)
* Mariadb

## Installation

For local development using Docker with Makefile. Just to run these commands:

```
# start all services
make up

# start a new shell session in the container
make web

# install composer packages
composer install

# install NPM packages
npm install
```

So use the http://localhost:8080/api as the base for each api endpoint.

## PHPStan

PHPStan is a powerful static analysis tool for PHP that helps you find and fix potential issues in your codebase. This section of the README will guide you through the process of integrating and using PHPStan in your project.
Once you've configured PHPStan, you can run it to analyze your codebase for issues. Use the following command:

```
make phpstan
```

## Coding Standards

Laravel Pint is an opinionated PHP code style fixer for minimalists. Pint is built on top of PHP-CS-Fixer and makes it simple to ensure that your code style stays clean and consistent.

Execute this command to run:

```
# inspect code for style errors without actually changing the files
make ccs

# fix code style issues
make fcs
```

## Tests

Execute this command to run tests:

```
make test
```
