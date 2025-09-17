# Installation
1. clone the repo and delete previous git files
    ```bash
    git clone https://github.com/thirdeyesystems/travelwebsitehf.git newproject/
    sudo rm -r .git
    ```
    optionally, initialize a new git repo
    ```bash
    git init
    ```
1. copy .env.example to .env
    ```bash
    cp .env.example .env
    ```
1. generate key
    ```bash
    php artisan key:generate
    ```
1. install dependencies
    ```bash
    composer install
    npm install && npm run build
    ```
1. create database, change the `DB_DATABASE` config in `.env`, and run migrations
    ```bash
    php artisan migrate
    ```
1. create storage symlink
    ```bash
    php artisan storage:link
    ```
# Todo
- [x] minify
- [x] image resizing and compression
- [x] sitemap
- [ ] seo-score
- [ ] plan your trip different design