# Desafio Técnico: Carteira Financeira

Sistema de simulação de uma carteira financeira

> Status: Developed

## Funcionalidades

-   Cadasro de usuários e suas carteiras financeiras
-   Autenticação de usuários
-   Operações Financeiras:
    -   Depósitos de dinheiro e reversão de depósitos
    -   Saques de dinheiro
    -   Transferências de dinheiro entre carteiras de usuários e reversão de transferência
    -   Verificação de saldo ao tranfererir valores
-   Visualização das carteiras com informações das operações

[Documento explicativo sobre o sistema](https://docs.google.com/document/d/1B_j0qzazW0F3CCtLbm4SM1B8Ph-UFHkb/edit?usp=sharing&ouid=116466061483400451914&rtpof=true&sd=true)

## Tecnologias Utilizadas:

<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original-wordmark.svg" alt="docker" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/composer/composer-original.svg" alt="composer" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="php" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" alt="laravel" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original-wordmark.svg" alt="postgresql" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="html5" width="40" height="40" style="max-width:100%;"></img>
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" alt="bootstrap" width="40" height="40" style="max-width:100%;"></img>

## Instalação e execução do projeto via docker

Como pré-requisito para a execução do projeto é necessário ter instalado na máquina o `docker` para a criação do ambiente. Para instalar e executar o projeto é necessário fazer o clone do mesmo e acessar o diretório do projeto baixado para executar, em sequência, as seguintes ações:

-   Crie um arquivo de nome `.env` e insira nele as informações do arquivo `.env.example`. Obs: também pode ser feito usando as linhas de comando:
    ```bash
    cp .env.example .env
    ```

-   Após criar o arquivo `.env` edite as seguintes variáveis de ambiente
    ```
    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=carteira_financeira_db
    DB_USERNAME=carteira_financeira_user
    DB_PASSWORD=carteira_financeira_password
    ```

-   Execute os próximos comandos em sequência

    -   Criar os containers no docker
        ```bash
        docker-compose up -d
        ```
    -   Instalar as dependências do backend via composer
        ```bash
        docker-compose run --rm composer install
        ```
    -   Gerar a chave do sistema
        ```bash
        docker-compose run --rm artisan key:generate
        ```
    -   Criar o link de armazenamento de arquivos
        ```bash
        docker-compose run --rm artisan storage:link
        ```
    -   Instalar as dependências do frontend via npm
        ```bash
        docker-compose run --rm npm install
        ```
    -   Compilar as dependências do frontend via npm
        ```bash
        docker-compose run --rm npm run build
        ```
    -   Criar as tabelas no banco de dados com dados iniciais
        ```bash
        docker-compose run --rm artisan migrate --seed
        ```
    -   Permitir o acesso do docker às pastas
        ```bash
        docker exec -it carteira_financeira-app chown -R www-data:www-data /var/www/storage
        ```
    -   Após os comandos acesse o projeto em: [http://localhost/](http://localhost/)

## Instalação e execução do projeto sem docker

Como pré-requisito para a execução do projeto é necessário ter instalado na máquina o `PHP` na versão `12 ou superior`, o `composer` na versão mais recente, o bando de dados `PostgresSQL` na versão `12 ou superior` e o `node` na versão `18 ou superior` para a criação do ambiente. Para instalar e executar o projeto é necessário fazer o clone do mesmo e acessar o diretório do projeto baixado para executar, em sequência, as seguintes ações:




-   Crie um arquivo de nome `.env` e insira nele as informações do arquivo `.env.example`. Após criar o arquivo `.env` edite as seguintes variáveis de ambiente
    ```
    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=carteira_financeira_db
    DB_USERNAME=carteira_financeira_user
    DB_PASSWORD=carteira_financeira_password
    ```

-   Execute os próximos comandos em sequência


    -   Instalar as dependências do backend via composer
        ```bash
        composer install
        ```
    -   Gerar a chave do sistema
        ```bash
        php artisan key:generate
        ```
    -   Criar o link de armazenamento de arquivos
        ```bash
        php artisan storage:link
        ```
    -   Instalar as dependências do frontend via npm
        ```bash
        npm install
        ```
    -   Compilar as dependências do frontend via npm
        ```bash
        npm run build
        ```
    -   Criar as tabelas no banco de dados com dados iniciais
        ```bash
        artisan migrate --seed
        ```
    -   Após os comandos acesse o projeto em: [http://localhost:8000/](http://localhost:8000/)
