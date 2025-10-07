<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# 🧠 Quiz Application API (Laravel 12.x)

A clean, modular, and production-ready **Quiz Management REST API** built with **Laravel**.  
It allows users to create quizzes, add questions and options, attempt quizzes, and automatically evaluate scores.

---

## 🚀 Features

- 🔐 JWT Authentication (Register, Login, Logout)
- 🧾 Quiz & Question Management
- ❓ Multiple Choice Options (one correct answer)
- 🧍 User Attempts & Score Calculation
- 📊 Result Evaluation & API Responses
- 💾 MySQL Database Integration
- ⚙️ RESTful JSON Endpoints
- 🧪 Postman Collection for Testing

---

## 🛠️ Tech Stack

| Component | Technology |
|------------|-------------|
| **Framework** | Laravel 12.x |
| **Language** | PHP 8.4+ |
| **Database** | MySQL |
| **Auth** | tymon/jwt-auth |
| **Testing** | Postman / Thunder Client |
| **API Format** | REST JSON |

---
## ⚙️ Api Collection link
https://blue-flare-105089.postman.co/workspace/My-Workspace~d24a8e70-8c58-41e7-8ea6-4e259c76cd4a/collection/26640235-edb58aa4-100d-4ba6-82d4-295b780893d1?action=share&creator=26640235&active-environment=26640235-60f0d204-99b7-4d4f-8989-f283a6cd9c4c
## ⚙️ Installation & Setup
1️⃣ Clone Repository

git clone https://github.com/<your-username>/quiz-api.git
cd quiz-api

2️⃣ Install Dependencies

composer install

3️⃣ Create Environment File
cp .env.example .env

Then Update your env file 
APP_NAME=QuizAPI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quiz_app
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Generate Application Key
php artisan key:generate

5️⃣ Configure JWT Authentication
Install JWT package (if not already installed):
composer require tymon/jwt-auth

Publish and generate JWT secret key:
--bash:
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret

This will generate a unique JWT_SECRET in your .env file.

6️⃣ Run Migrations & Seed Database
php artisan migrate
php artisan db:seed

7️⃣ Start Local Server
php artisan serve

Your API will now be live at:
➡️ http://127.0.0.1:8000


This the API Collection Link:
 https://blue-flare-105089.postman.co/workspace/My-Workspace~d24a8e70-8c58-41e7-8ea6-4e259c76cd4a/collection/26640235-edb58aa4-100d-4ba6-82d4-295b780893d1?action=share&creator=26640235&active-environment=26640235-60f0d204-99b7-4d4f-8989-f283a6cd9c4c

