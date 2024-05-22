## Sistema simples de supermercado

Este projeto é um sistema simples de gerenciamento de supermercado, desenvolvido em PHP sem frameworks adicionais. Utilizamos PostgreSQL como banco de dados, Docker para contêinerização e Tailwind CSS para estilização.

## Tecnologia

A Stack deste projeto é a seguinte:

#### Backend
- PHP 8.1 
- Postegres
  
#### Frontend
- HTML
- Tailwind CSS
- JavaScript

### Executando com Docker

1. Instale o Docker e Docker Compose
2. Execute o comando "docker-compose up -d --build"
3. Acesse o container com o comando "docker-compose exec -it supermarket-php-1 bash"
4. Dentro do container execute os comandos "composer install" e "composer dump-autoload"
5. Acesse o projeto no seu ambiente local [http://localhost](http://localhost)

### Configurações banco de dados

As configurações de conexão com o banco de dados estão no arquivo app/models/Database.php. 
Certifique-se de que os parâmetros de conexão (host, db, user, password) estão corretos.
