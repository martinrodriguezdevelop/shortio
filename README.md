### DEMO URL
https://moonlit-lima-edewxminolxs.vapor-farm-g1.com

user: demo@demo.com
password: demo

## Run local env

### Step 1 - Add this line to /etc/hosts

`127.0.0.1 short.vm`


### Step 2 - Build images

`cp .env.example .env`
`docker network create nginx-proxy`
`sudo docker-compose build`
`sudo docker-compose up -d`


### Step 3 - Connect to app terminal

sudo docker exec -it shortio /bin/bash


### Step 4 - Install Composer Packages

`composer install`
`php artisan key:generate`
`php artisan passport:install`


### Step 5 - Run migrations

`php artisan migrate`

### Step 6 - Go to http://short.vm/

___