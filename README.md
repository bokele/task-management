# Simple Loan management system

<p align="center"><a href="https://github.com/bokele" target="_blank">
<img src="/public/assets/dashboard.png" width="400"></a></p>

# Brief

> simple Laravel web application for task management.

# Objective

> Build a system that will enable the company to task process with the necessary business rules.

# Tasks

-   implement the system with a framework of your choice.
-   Package the solution in a deployable package or hos it and share the url, include a readme file for instructions.
-   Include a brief write up describing your solution

## Requirements

-   Php 8.1 and above
-   Composer
-   Since this project is running laravel 9, we suggest checking out the official requirements [here](https://laravel.com/docs/9.x/upgrade#updating-dependencies)

## Installation

-   Clone the repository by running the following command in your comamand line below (Or you can dowload zip file from github)

```shell
git clone git@github.com:bokele/task-management.git  ./task-management
```

-   Head to the project's directory

```shell
cd task-management
```

-   Install composer dependancies

```shell
composer install
```

-   Copy .env.example file into .env file and configure based on your environment

```shell
cp .env.example .env
```

-   Generate encryption key

```shell
php artisan key:generate
```

-   Migrate the database

```shell
php artisan migrate
```

-   Seed database
    ```shell
    php artisan db:seed
    ```
-   Install npm dependancies

```shell
npm install
```

-   For development or testing purposes, you can use the laravel built in server by running

```shell
npm run dev
```

```shell
php artisan serve
```

## Setup

-   Log in to the application with the following credentials

    -   Register and login

### Admin

-   Ability to manage all Project
-   Ability to create, edit, view and delete Project
-   Ability to create, edit, view and delete Task
