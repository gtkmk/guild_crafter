# Guild Crafter
### Monte sessões de RPG e organize Jogadores por Classe e XP em guildas rivais.

Disponível pelo link abaixo:

[http://crafter.web201.uni5.net/](http://crafter.web201.uni5.net/)

**Atenção:** Por não possuir certificado, e talvez por ser uma aplicação Laravel, o site está sendo visto como malicioso. Ao menos no meu caso, foi necessário pausar a proteção do antivírus.

**Fique atento ao link.** Certifique-se que não foi redirecionado por motivos citados acima. Garanta que a URL tenha *.web201*.

# Algoritmo de Balanceamento

O algoritmo de balanceamento de jogadores por classe e XP utiliza uma abordagem **Greedy (Ávida) com Restrições**. Ele funciona da seguinte forma:

**Organização dos Jogadores:**

- Os jogadores são agrupados por sua classe e ordenados de forma decrescente pelo XP.

**Composição Mínima:**

- A primeira etapa é garantir que cada guilda tenha pelo menos:
- 1 Guerreiro
- 1 Clérigo
- 1 Mago OU Arqueiro

**Distribuição Alternada:**

- A partir da composição mínima, os jogadores restantes são distribuídos nas guildas alternadamente, com a prioridade de balancear o número de jogadores e o XP total entre as guildas.

**Balanceamento de XP:**

- O algoritmo verifica a diferença de XP entre as guildas a cada adição de jogador, tentando manter as guildas o mais equilibradas possível.

**Respeito ao Número de Jogadores:**

- Caso o número de jogadores seja menor que duas vezes o número de jogadores por guilda, é gerada apenas uma guilda. Caso contrário, duas guildas são formadas com o número de jogadores igual.

Essa abordagem garante que as guildas sejam balanceadas de acordo com as classes e o XP, respeitando as restrições impostas, ao mesmo tempo em que distribui os jogadores de maneira eficiente.

## Algoritmo Greedy (Ávido)

O algoritmo Greedy (ou Ávido) é uma forma de otimização que faz escolhas locais ótimas em cada etapa. Ele seleciona a melhor opção disponível no momento, sem considerar as consequências futuras.

**Teoria**

Embora o algoritmo Greedy possa não garantir uma solução global ótima, ele é eficiente em problemas onde soluções locais ótimas levam a um bom resultado geral. As principais propriedades incluem:

- **Escolha Gananciosa:** A melhor opção é escolhida a cada passo, sem revisar decisões anteriores.
- **Subestrutura Ótima:** A solução global é composta por soluções ótimas locais.
- **Simplicidade:** O Greedy é mais simples e rápido de implementar do que outros algoritmos mais complexos, tornando-se uma boa escolha em problemas com muitas restrições. Ele minimiza as chances de erros e bugs, mesmo que não seja o mais eficiente, nesse contexto é uma boa escolha.

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
