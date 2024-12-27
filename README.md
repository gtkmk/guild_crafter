# Guild Crafter
### Monte sessões de RPG e organize Jogadores por Classe e XP em guildas rivais.

Disponível pelo link abaixo:

[http://crafter.web201.uni5.net/](http://crafter.web201.uni5.net/)

**Atenção:** Por não possuir certificado, e talvez por ser uma aplicação Laravel, o site está sendo visto como malicioso. Ao menos no meu caso, foi necessário pausar a proteção do antivírus.

**Fique atento ao link.** Certifique-se que não foi redirecionado por motivos citados acima. Garanta que a URL tenha *.web201*.

# Algoritmo de Balanceamento

O algoritmo de balanceamento de jogadores por classe e XP funciona da seguinte maneira:

**Agrupamento por classe:**

- Inicialmente, todos os jogadores são agrupados de acordo com sua classe.

**Ordenação por XP:**

- Dentro de cada grupo de classe, os jogadores são classificados em ordem decrescente de XP (experiência).

**Distribuição inicial entre guildas:**

- Os jogadores são distribuídos alternadamente entre duas guildas (grupos).

**Balanceamento por classe:**

- Para cada jogador adicionado a uma guilda, O algoritmo verifica se a guilda já possui jogadores da mesma classe.
- Caso já exista jogador de mesma classe, o jogador com menor XP dessa classe na guilda é identificado.
- Esse jogador de menor XP é realocado para a guilda oposta.

**Otimização por XP total:**

- O processo continua até que todos os jogadores sejam distribuídos e a diferença de XP total entre as duas guildas seja minimizada.

**Quer que desenhe?** Acesse o rascunho abaixo:
[https://excalidraw.com/](https://excalidraw.com/#json=2SNZOvnFJd99wHOXHKoO7,nzjyStxKW3ufuKhxgVzC3w)

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
