<img src="./assets/images/Atalaya_primary.svg" width="220" alt="Atalaya">

Atalaya provides self-hosted errors monitoring that aims to ease discovery and review of unhandled exceptions thrown by other applications.

# Contributing
Atalaya is Open Source, contributions are really appreciated (and necessary).

## Requirements
- [Git](https://git-scm.com/)
- [PHP 7.4+](https://www.php.net/downloads.php)
- [Symfony CLI](https://symfony.com/download)
- [MariaDB](https://mariadb.org/)
- [Node.js](https://nodejs.org/es/)

## Running locally
** *DO NOT INSTALL IN PRODUCTION ENVIRONMENTS.* **

1. Clone this repository: `git clone https://github.com/ayrad/atalaya.git Atalaya && cd Atalaya`
2. Install Composer packages: `symfony composer install`
3. Install NPM packages: `npm install`
4. Build Atalaya's UI:  `npm run build`
5. Copy .env into .env.local `cp .env .env.local` and modify it accordingly (e.g. to set DATABASE_URL)
6. Execute migrations: `symfony console d:m:m -n`
7. Load data fixtures: `symfony console d:f:l -n`
8. Atalaya uses JWT (JSON Web Token) to authenticate users. A pair of SSL keys (public and private) are required. Use OpenSSL or any other tool to generate them:
    * Generate private key: `openssl genrsa -out var/jwt/private.pem 2048`
    * Generate public key: `openssl rsa -in var/jwt/private.pem -outform PEM -pubout -out var/jwt/public.pem`
    * Remove password from private key (if any): `openssl rsa -in var/jwt/private.pem -out var/jwt/private.pem`
9. Run local server `symfony serve`
10. Go to https://localhost:8000
11. Log in using the test username `john.doe@atalaya.tech` and password `john123`
