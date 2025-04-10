<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🎭 Сайт бронирования онлайн-билетов в кинотеатр и разработка информационной системы для администрирования залов, сеансов и предварительного бронирования билетов

Это административная панель на Laravel для управления залами, сеансами и конфигурациями кинотеатра. Используется современный стек: Laravel + Vite + Blade-компоненты.

---

## 🚀 Стек технологий

- **Laravel**: v12.2.0
- **PHP**: v8.3.12
- **MySQL**: v8.0
- **Vite**: v4.0.15
- **Composer**, **NPM**

---

## 📦 Установка

```bash
git clone https://github.com/ns-morozova/cinema.git
cd cinema

composer install
npm install
cp .env.example .env
php artisan key:generate
