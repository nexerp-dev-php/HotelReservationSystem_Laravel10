docker-compose down

php artisan optimize

docker-compose build

docker-compose up -d

docker exec -it laravel10-app php artisan key:generate
docker exec -it laravel10-app php artisan migrate

docker exec -it laravel10-app php artisan config:cache
docker exec -it laravel10-app php artisan route:cache

docker exec -it laravel10-app chmod -R 775 storage bootstrap/cache
docker exec -it laravel10-app chown -R www-data:www-data storage bootstrap/cache

docker stop laravel10-app
docker start laravel10-app