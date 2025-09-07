<h1 align="center">Assessment Task Manager</h1>

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  Aplikasi manajemen tugas yang dibangun dengan Laravel dan Filament PHP
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-FF3852?style=for-the-badge" alt="Filament">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
</p>

## 📋 Tentang Aplikasi

Assessment Task Manager adalah aplikasi manajemen tugas yang menyediakan antarmuka admin untuk mengelola tugas, pengguna, dan kategori. Dibangun dengan Laravel dan menggunakan Filament PHP sebagai admin panel.

## ✨ Fitur

-   ✅ Manajemen tugas dengan status
-   👥 Manajemen pengguna
-   📂 Kategori tugas
-   ⚡ Prioritas tugas
-   📅 Pelacakan deadline

## 🛠️ Teknologi

-   **Laravel 10** - PHP Framework
-   **Filament V3.3 PHP** - Admin Panel
-   **MySQL** - Database
-   **Tailwind CSS** - Styling

## 🚀 Instalasi

1. **Clone repository**
    ```bash
    git clone https://github.com/roldleo/assessment-eminence
    cd assessment-eminence
    ```
2. **Install dependencies**
    ```bash
    composer install
    ```
3. **Setup environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. **Jalankan migration dan seeder**
    ```bash
    php artisan migrate --seed
    ```
5. **Jalankan aplikasi**
    ```bash
    php artisan serve
    ```

## 🔐 Akun Default

Admin
Email: admin@task.com
Passowrd: admin123

Developer
Email: dev@task.com
Password: developer123
