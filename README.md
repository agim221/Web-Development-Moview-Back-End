# Moview

## Project Description

Moview merupakan sebuah website yang didesain untuk membantu user mencari, menilai, dan mengomentari film. Terinspirasi dari IMDb, Moview memungkinkan user untuk mencari film, meninggalkan komentar, dan menambahkan film ke dalam daftar tontonan. Platform ini mendukung dua roles, yaitu:

-   **Admin**: Dapat mengatur data film, data aktor, data negara, data award, dan data user.
-   **User**: Dapat mencari film, memposting sebuah film, menambahkan film ke dalam daftar tontonan, dan memberi komentar.

## Installation

Untuk penginstalan aplikasi ini terdapat dua versi, yaitu penginstalan versi lokal dan versi Docker. Klik [di sini](https://github.com/agim221/Web-Development-Moview-Back-End) untuk penginstalan versi lokal. Ikuti instruksi di bawah ini untuk penginstalan versi Docker:

### 1. Prerequisites

-   Node.js (v20 or higher)
-   npm (v10 or higher)
-   Laravel (v11) with passport installed
-   PostgreSQL
-   Python
-   Docker

### 2. Create folder for project

-   `mkdir moview`
-   `cd moview`

### 3. Install Frontend

-   Make sure you're in the folder project
-   Clone Repository <br>
    `git clone https://github.com/agim221/Web-Development-Moview` <br>
    `cd Web-Development-Moview`
-   Install package needed
    `npm install`

### 4. Install Backend

-   Make sure you're in the folder project
-   Clone Repository
    `git clone https://github.com/agim221/Web-Development-Moview-Back-End`
    `cd Web-Development-Moview-Back-End`
-   Install Dependencies
    `composer install`
-   Create environment
    `cp .env.example .env`
-   Generate key
    `php artisan key:generate`
-   Configure your database settings in the .env file
-   Run database migrations
    `php artisan migrate`
-   Run this python script to input film data
    `python nama-file.py`
-   Run database seed
    `php artisan db:seed --class=DatabaseSeeder`
-   Install Laravel Passport for API authentication
    `php artisan passport:install`

## Features

1. Register and Login:
    - User dapat membuat akun dan melakukan login.
2. Mencari Film:
    - Gunakan bar pencarian untuk mencari film.
    - Gunakan filter bar untuk mencari film dengan spesifikasi tertentu.
3. Komentar:
    - Menambahkan komentar ke sebuah film.
4. Menambah Film:
    - User dapat menambahkan sebuah film dengan mengisi form "Add Movie".
5. Content Management System:
    - Admin dapat mengatur data-data film.
    - Admin dapat mengatur akun user.

## Credit

Author: Agim, Zahran

## References

-   [Install PHP](https://youtu.be/n04w2SzGr_U?si=sjD0qlwKKgKink4t)
-   [Install Node.js](https://youtu.be/06X51c6WHsQ?si=mkXpJFxfmcb-oBPo)
-   [Install PostgreSQL](https://youtu.be/uN0AfifH1TA?si=EcvAHVogRiIm3UnZ)
-   [Setting OAuth](https://youtu.be/r8sVXy7lSTM?si=DGc_rI0c2GrWHTHD)
-   [Setting env for database](https://medium.com/@erlandmuchasaj/laravel-env-5fe7f88bd256)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
