<h1 align="center" style="font-size: 32px; font-weight: 800;"> Inventory Track </h1> <br>
<p align="center">
  <a href="https://github.com/SalmanDMA/technical-test-inventory-track-laravel">
    <img alt="GitPoint" title="GitPoint" src="public/images/logo.png" style="width: 150px; border-radius: 50%;">
  </a>
</p> <br>

 <p align='center' style="font-size: 16px; font-weight: 400;"> Reach Me On :</p>
 
  <p align='center'>
  <a href="https://bit.ly/my-portofolio-salmandma">
    <img src="https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white" alt="portfolio">
  </a>
  <a href="https://www.linkedin.com/in/salmandma/">
    <img src="https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white" alt="linkedin">
  </a>
  <a href="https://www.instagram.com/_slmndma_">
    <img src="https://img.shields.io/badge/instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="instagram">
  </a>
  <a href="https://github.com/SalmanDMA">
    <img src="https://img.shields.io/badge/github-181717?style=for-the-badge&logo=github&logoColor=white" alt="github">
  </a>
</p>

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->

## Table of Contents

-   [Introduction](#introduction)
-   [Features](#features)
-   [Technologies](#technologies)
-   [Installation](#installation)
-   [Contributors](#contributors)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Introduction

[![On Process](https://img.shields.io/badge/build-on_process-blue)](https://github.com/SalmanDMA/alternatif-blog-api)
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors-)

Welcome to the inventory track, where you as a user can create a loan item, and of course have to return the item yes, here also consists of 3 roles, please scroll down to find out more about the role, which is definitely interesting to explore, so what are you waiting for, do it now.

## Features

Here are some features of Alternatif API:

-   Loan and return form (user)
-   User CRUD and item CRUD (admin & superadmin)
-   Other activities

## Technologies

-   Laravel
-   Tailwind CSS
-   Blade Templates
-   Toastr (for notifications)
-   Laravel Excel (for exporting data to Excel)

## Installation

1. Clone Repository:

```bash
 git clone https://github.com/SalmanDMA/technical-test-inventory-track-laravel.git
```

2. Go to Directory:

```bash
 cd technical-test-inventory-track-laravel
```

3. Install Dependensi:

```bash
 composer install
```

4. Set Up Environment Variables:

    Open the .env file inside the project directory and set the necessary environment variables. Make sure to set variables like `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` if you are using mysql. Skip this step if you are not using mysql. And Configure according to the database you want to use

5. Run Run Migrations:

```bash
 php artisan migrate
```

6. Make sure the connection with the database is running smoothly

7. Serve the Application and Run Vite

```bash
 php artisan serve
 npm run dev
```

8. Run seeder

```bash
 php artisan db:seed --class=UsersTableSeeder
 php artisan db:seed --class=ItemsTableSeeder
 php artisan db:seed --class=ActivitiesTableSeeder
```

9. Change the user role to

```bash
1 User
1 Admin
1 Superadmin
```

Note: This web has 3 roles, namely user, admin, and superadmin, the user can only do the loan and return form, and view information from the results, then the admin can perform user CRUD operations (but cannot add users as admins), CRUD items, and can see other activities available on the website, then finally superadmin, of course it is clear that the name is also super means that you can do anything and surf freely there.

10. Access Applications:

    The application will run on `http://localhost:8000` by default. You can access it using any web browser.

11. Enjoy

## Contributors

This project is maintained by [Salman DMA](https://github.com/SALMANDMA).
