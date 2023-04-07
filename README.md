# Hosting with Docker

After starting the docker service, you may need to run migrations. To do this
```bash
docker exec <container_id> php artisan migrate
```

Create a new token holder: `docker exec <container> php artisan app:create_tokenholder {name}`
Create a new token: `docker exec <container> php artisan app:create_token {token_holder}`
