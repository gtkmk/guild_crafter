# Guild Crafter
### Monte sessões de RPG e organize Jogadores por Classe e XP em guildas rivais.

# Setup Docker Laravel 11 com PHP 8.3

### Passo a passo
Clone Repositório
```sh
git clone git@github.com:gtkmk/guild_crafter.git
```
```sh
cd app-laravel
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Rodar as migrations
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)
