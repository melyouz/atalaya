<img src="./assets/images/Atalaya_primary.svg" width="220" alt="Atalaya">

Atalaya provides self-hosted errors monitoring that aims to ease discovery and review of exceptions thrown by other applications.

# Contributing
Atalaya is Open Source, contributions are really appreciated (and necessary).

## Requirements
- [Git](https://git-scm.com/)
- [PHP 7.4+](https://www.php.net/downloads.php)
- [MariaDB](https://mariadb.org/)
- [Node.js](https://nodejs.org/es/)

## Running locally
** *DO NOT INSTALL IN PRODUCTION ENVIRONMENTS.* **

1. Clone this repository: `git clone https://github.com/ayrad/atalaya.git Atalaya && cd Atalaya`
2. Install Composer packages: `php bin/composer install`
3. Install NPM packages and build Atalaya UI: `npm install && npm run build`
4. Copy .env into .env.local `cp .env .env.local` and modify it accordingly (e.g. to set DATABASE_URL)
5. Execute migrations: `php bin/console d:m:m`
6. Atalaya uses JWT (JSON Web Token) to authenticate users. A SSL keys pair (public and private) are required. Use OpenSSL or any other tool to generate them:
    * Generate private key: `openssl genrsa -out var/jwt/private.pem 2048`
    * Generate public key: `openssl rsa -in var/jwt/private.pem -outform PEM -pubout -out var/jwt/public.pem`
    * Remove password from private key (if any): `openssl rsa -in var/jwt/private.pem -out var/jwt/private.pem`
7. Run local server using [Symfony CLI](https://symfony.com/download) `symfony serve` or using PHP Development Server `php -S localhost:8000 -t public &`
8. Register and confirm a new user using cURL or any other tool such as Postman (this will be soon part of an installation wizard / data fixture):
```bash
curl --location --request POST 'http://localhost:8000/api/users' \
--header 'Content-Type: application/json' \
--header 'Content-Type: text/plain' \
--data-raw '{
	"name": "{firstname} {lastname}",
	"email": "{email}",
	"password": "{password}"
}'
```
```bash
curl --location --request PATCH 'http://localhost:8000/api/users/{confirmation_token}/confirm' \
--header 'Content-Type: application/json' \
--data-raw ''
```
9. Go to http://localhost:8000
