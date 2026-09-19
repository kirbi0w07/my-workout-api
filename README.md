# 🏋️ Workout API

A RESTful API built with **Laravel** to provide authentication, exercises, workout plans, and training session management for the Workout mobile application.

> 🚧 **Project status: In Development**
>
> This API is being developed as part of my software development portfolio and serves as the backend for a React Native / Expo mobile application.

## 📖 About the Project

Workout API provides the backend services required by the Workout mobile application.

The API is responsible for:

* User authentication
* User management
* Exercise management
* Workout plans
* Workout exercises
* Training sessions
* Data validation
* Database persistence
* Protected API resources

The project follows a RESTful architecture and is designed to separate business logic, API resources, authentication, and data persistence.

## 🛠️ Tech Stack

* **Laravel**
* **PHP**
* **Laravel Passport**
* **PostgreSQL**
* **REST API**
* **Eloquent ORM**
* **Laravel Validation**
* **Database Migrations & Seeders**

## 🏗️ Architecture

```text
React Native / Expo
        │
        │ HTTP / JSON
        ▼
   Laravel REST API
        │
        ├── Authentication
        ├── Controllers
        ├── Validation
        ├── Services
        └── Eloquent Models
                │
                ▼
           PostgreSQL
```

## 🔐 Authentication

The API uses **Laravel Passport** for token-based authentication.

The authentication flow is based on bearer tokens:

```http
Authorization: Bearer {token}
```

After successfully authenticating, the API returns an access token that the mobile application uses when accessing protected endpoints.

### Example Login Request

```http
POST /api/login
Content-Type: application/json
Accept: application/json
```

Request body:

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

Example response:

```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com"
    },
    "token": "..."
}
```

## 📚 Main Resources

The API is designed around the following resources:

```text
Users
  │
  └── Workout Plans
          │
          └── Workout Exercises
                  │
                  └── Exercises

Users
  │
  └── Workout Sessions
```

### Exercises

Exercise records contain information used to build workout routines.

### Workout Plans

Users can create workout plans containing multiple exercises.

Each workout exercise can define parameters such as:

* Sets
* Repetitions
* Rest time
* Exercise order

### Workout Sessions

Workout sessions are intended to track actual training activity and provide the foundation for future progress tracking.

## 📂 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
│
├── Models/
│
└── ...

database/
├── migrations/
├── seeders/
└── ...

routes/
└── api.php
```

> The structure may evolve as the project grows.

## 🗄️ Database

The API uses **PostgreSQL** as its database engine.

Current core entities include:

```text
users
profiles
exercises
workout_plans
workout_exercises
sessions
```

Database structure is managed through Laravel migrations.

Exercise data is populated using database seeders based on the exercise dataset used by the application.

## 🚀 Getting Started

### Requirements

* PHP 8.4+
* Composer
* PostgreSQL
* Node.js / npm
* Laravel
* Laravel Passport

### Installation

Clone the repository:

```bash
git clone https://github.com/kirbi0w07/my-workout-api.git
cd my-workout-api
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the PostgreSQL database in `.env`.

Example:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=my_workout_api
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Run migrations:

```bash
php artisan migrate
```

Run seeders:

```bash
php artisan db:seed
```

Start the development server:

```bash
php artisan serve
```

For mobile-device development, the API can be exposed on the local network:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 🔌 API Example

Example authenticated request:

```http
GET /api/workout-plans
Authorization: Bearer {token}
Accept: application/json
```

Example response:

```json
{
    "data": []
}
```

## 🧪 API Development

The API can be tested using tools such as:

* Postman
* Insomnia
* Mobile application client

The API returns JSON responses and uses HTTP status codes to communicate validation, authentication, and server errors.

## 🗺️ Development Roadmap

* [x] Laravel API setup
* [x] PostgreSQL integration
* [x] Authentication
* [x] Laravel Passport
* [x] Exercise model and database structure
* [x] Workout plan structure
* [x] Workout exercise relationships
* [x] Validation
* [x] Login endpoint
* [ ] Logout endpoint refinement
* [ ] Workout plan CRUD
* [ ] Exercise API endpoints
* [ ] Workout session management
* [ ] Progress tracking
* [ ] API resources / response standardization
* [ ] Automated tests
* [ ] API documentation
* [ ] Production deployment

## 🎯 Portfolio Goals

This project demonstrates practical experience with:

* Laravel REST API development
* PHP
* PostgreSQL
* Authentication with Laravel Passport
* Eloquent ORM
* Database relationships
* Request validation
* RESTful API design
* API architecture
* Mobile-to-backend integration
* React Native API consumption

## 📌 Project Status

**In Development 🚧**

The API is actively being developed alongside the React Native mobile application. Endpoints, database structures, and features may change during development.

## 🔗 Mobile Application

The API is consumed by the Workout mobile application built with React Native and Expo.

> Repository: `https://github.com/kirbi0w07/my-workout-app.git`
