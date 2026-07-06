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

git clone https://github.com/jcadima/dvla
cd dvla
docker compose up -d

# App runs at http://localhost:8084


---

## The Kill Chain

| Step | Vulnerability                                  | Severity | Blog Post              |
|------|-------------------------------------------------|----------|------------------------|
| 0    | Lab setup and Docker overview                  |          | [Post 0](https://jcadima.dev/blog/getting-started-docker-laravel-security-lab)         |
| 1    | Mass assignment, instant admin                 | High     | Coming Week 1          |
| 2    | nginx misconfiguration, .env leak -> APP_KEY RCE | Critical | Coming Week 2          |
| 3    | PHP type juggling, auth bypass                 | Critical | Coming Week 3          |
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

dvla/
  docker-compose/
    nginx/
    mysql/
  app/
  database/
    migrations/
    seeders/
  Dockerfile
  docker-compose.yml
  .env.example
  README.md

---

## Resetting the Lab

docker compose down -v
docker compose up -d

This wipes all data and starts clean. Useful between exercises.

---

## License

MIT. Educational use only.