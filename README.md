# Back-end Challenge 🏅 2021 - Space Flight News

Este projeto é a resolução do desafio da Coodesh e consiste em uma API para manipulação
de artigos.

## Tecnologias

- [Lumen 8](https://lumen.laravel.com/docs/8.x)
- [Lumen Generator](https://github.com/flipboxstudio/lumen-generator)
- [MongoDB](https://www.mongodb.com/) com [jenssegers/laravel-mongodb](https://github.com/jenssegers/laravel-mongodb)
- [PHPUnit](https://phpunit.de)
- [Docker](https://www.docker.com/) com [compose](https://docs.docker.com/compose/)
- [OpenAPI 3.0](https://swagger.io/)

## Instruções

Antes de prosseguir, tenha certeza de ter o [docker](https://docs.docker.com/) devidamente instalado
e configurado em sua máquina, juntamente com o [compose](https://docs.docker.com/compose).

### Instalação

1. Baixe o projeto com git ou faça o download manualmente.

```bash
git clone https://github.com/JorgeEmanoel/coodesh-spaceflight-api-challenge.git spaceflight-api && cd spaceflight-api
```

2. Copie o arquivo `.env.example` e o renomeie para `.env`

```bash
cp .env.example .env
```

3. Altera as variáveis que definem as portas do seu projeto

```env
APP_PORT=9000
DOCS_PORT=9001
```

As variáveis acima serão utlizadas pelo docker para definir as portas da API e da Documentação do swagger,
respectivamente.

4. Suba o projeto utilizando `docker-compose`

```bash
docker-compose up -d
```

5. Instale as dependências

```bash
docker exec spaceflight_api composer install
```

Para prosseguir com os testes, devemos realizar a configuração completa do banco. Veja na próxima seção.

### Configuração do Banco

Configure corretamente as variáveis de ambiente para conexão com o banco de dados utilizando as credenciais definidas no
arquivo `docker-compose.yml`. Seu `.env` deve ficar parecido com isso:

```env
DB_CONNECTION=mongodb
DB_HOST=spaceflight_db
DB_PORT=27017
DB_DATABASE=spaceflight_db
DB_USERNAME=spaceflight
DB_PASSWORD=spaceflight
```

Note que o `DB_HOST` deve ser igual ao valor definido no `hostname` do container do MongoDB no arquivo `docker-compose.yml`.

### Testes

1. Faça uma cópia do seu `.env` para o arquivo `.env.testing`. Esse arquivo será considerado durante os testes.
É aconselhável que seja utilizado um banco de dados diferente para testes.

```bash
cp .env .env.testing
```

2. Após tudo configurado, execute os testes dentro do container da API.

```
docker exec spaceflight_api vendor/bin/phpunit
```

O resultado deve ser parecido com esse:

```bash
PHPUnit 9.5.11 by Sebastian Bergmann and contributors.

................................                                  32 / 32 (100%)

Time: 00:00.182, Memory: 22.00 MB

OK (32 tests, 69 assertions)
----
```

### Alimentando o banco

Para alimentar o banco, execute o comando `php artisan articles:seed --chunk-size=200`. O comando irá
consumir a API oficial e registrar os artigos obtidos no banco de dados local. A flag `--chunk-size` define
a quantidade de artigos obtidos por iteração, para evitar o sobrecarregamento do servidor.

### Configuração da CRON

A alimentação do banco deve ocorrer todo dia às 9:00 AM. Para isso, é necessário definir uma entrada cron
no servidor onde o projeto está. O Lumen cuidará do resto utilizando seu [sistema de schedule](https://laravel.com/docs/8.x/scheduling).

1. Acesse o crontab em modo de edição:
```
crontab -e
```

2. Insira a seguinte linha, salve e feche o arquivo:
```bash
* * * * * cd /pasta-do-projeto && php artisan schedule:run >> /dev/null 2>&1
```

### Documentação

Acesse a documentação através do endereço local: http://localhost:9001 (onde 9001 é a porta definida por você para o container da documentação).

### Video explicativo

https://www.loom.com/embed/7972bf73934c48aebcc9efc85350780e

## Licença

Este projeto está sob os termos da licença [Apache 2.0](https://www.apache.org/licenses/LICENSE-2.0).


>  This is a challenge by [Coodesh](https://coodesh.com/)
