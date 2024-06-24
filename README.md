# 📝 DESAFIO PAGINA DE VENDA


### Passo a passo
Clone Repositório
```sh
git clone https://github.com/eduardohor/pagina-de-venda.git
```
```sh
cd pagina-de-venda
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Crie o Arquivo .env
```sh
cp .env.example .env
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

Edite o arquivo .env com as informações do seu banco de dados local. Exemplo de configuração:
- DB_CONNECTION=mysql
- DB_HOST=db
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=username
- DB_PASSWORD=userpass

Rodar as migrations
```sh
php artisan migrate --seed
```

Instalar dependências para o front 
```sh
npm install
```

Para rodar o front no docker
```sh
npm run build
```

Acesse o projeto e cadastre seu usuario em /register

[http://localhost:8000](http://localhost:8000)

Acesse o phpmyadmin em: http://localhost:8080
