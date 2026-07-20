<p align="center">
  <img src="https://jcadima.dev/images/dvla-github.png" alt="Damn Vulnerable Laravel Application">
</p>

# Damn Vulnerable Laravel Application (DVLA)
### A Deliberately Vulnerable Laravel 12 Application

A modern, fully Dockerized lab environment for learning real-world 
Laravel security vulnerabilities. 

Built as a hands-on companion to the DVLA blog series on jcadima.dev/blog

> Run this locally or in an isolated VM only.
> Never expose it to the internet.

---

## Why This Exists

DVWA is useful but it targets vulnerability patterns from 2010.
Real Laravel applications fail in different ways: Eloquent mass 
assignment, type juggling in custom auth, APP_KEY deserialization, 
Redis job injection, container escapes via docker.sock.

DVLA covers the full kill chain of a modern Laravel 
application, from the first recon step to host compromise.

Project home [here](https://dvla.jcadima.dev)

---

## Prerequisites

- Docker
- Docker Compose
- Git

---

## Quick Start
```
git clone https://github.com/jcadima/dvla
cd dvla

# Copy the example environment file, the APP_KEY is intentionally hardcoded
# in .env.example and is required for several lab vulnerabilities to work
cp .env.example .env

docker compose up -d --build
```
Install PHP dependencies and set up the database (run inside the app container):
```
docker compose exec dvla-admin composer install
docker compose exec dvla-admin php artisan migrate --seed
```
Install front-end dependencies and build assets (run on your host machine, Node is not in the containers):
```
npm install
npm run build
```
Use `npm run dev` instead of `npm run build` if you want Vite's dev server with hot reload while working through the exercises.

# App runs at 
```
http://localhost:8084
```

# Admin login 
```
http://localhost:8084/login
```

| Default Credentials| |
|----------|---------|
| Email    | admin@artisanbreach.com |
| Password    | artisanpass123 |
---

## The Kill Chain

| Step | Vulnerability                                  | Severity | Blog Post              |
|------|-------------------------------------------------|----------|------------------------|
| 0    | Lab setup and Docker overview                  |          | [Setup](https://jcadima.dev/blog/getting-started-docker-laravel-security-lab)         |
| 1    | Mass assignment, instant admin                 | High     | [Post #1](https://jcadima.dev/blog/laravel-mass-assignment-vulnerability-eloquent)          |
| 2    | nginx misconfiguration, .env leak -> APP_KEY RCE | Critical | [Post #2](https://jcadima.dev/blog/nginx-env-file-exposure-laravel-app-key-rce)          |
| 3    | PHP type juggling, auth bypass                 | Critical | [Post #3](https://jcadima.dev/blog/php-type-juggling-authentication-bypass)          |
| 4    | IDOR on contributor routes                     | High     | Coming Week 4          |
| 5    | File Upload Bypass                             | High     | Coming Week 5          |
| 6    | Stored XSS via Blade bypass                    | High     | Coming Week 6          |
| 7    | Redis job injection via Horizon                | Critical | Coming Week 7          |
| 8    | docker.sock escape, host compromise            | Critical | Coming Week 8          |
| 9    | Full Kill Chain                                | Critical | Coming Week 9          |
--- 

## Stack

- Laravel 12
- PHP 8.3
- MySQL 8
- Redis
- Laravel Horizon
- Nginx
- Docker Compose

---

## Project Structure

```
dvla/
├── app/                  # Laravel application code (Models, Http, etc.)
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── docker-compose/
│   ├── nginx/
│   └── mysql/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
├── docker-compose.yml
├── Dockerfile
├── .env.example
├── package.json
└── README.md
```

---

## Resetting the Lab
```
docker compose down -v
docker compose up -d --build
docker compose exec dvla-admin php artisan migrate --seed
```
This wipes all data and starts clean. Useful between exercises.

---

## License

MIT. Educational use only.