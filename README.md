# Sistema para Jornalistas

A proposta era criar uma API voltada para jornalistas onde esses poderiam criar,
editar, remover e listar notícias e os tipos de notícias. As rotas deveriam ser protegidas por token
( JWT - JSON Web Token ) com tempo de expiração definido em 5 minutos.


## INSTALAÇÃO E CONFIGURAÇÃO DO PROJETO ( Linux ):

Abra um terminal e digite os comandos a seguir para baixar o projeto e suas dependencias
<ul>
    <li><em> git clone https://github.com/KaliaryCisne/api-jornal.git</em></li>
    <li><em> cd api-jornal/src </em></li>
    <li><em> composer install </em></li>
    <li><em> php artisan jwt:secret </em></li>
</ul>

## CRIANDO UM BANCO DE DADOS:
Caso você tenha instalado em sua máquina o Docker e o Docker-compose, utilize os comandos a baixo
para subir um servidor de banco de dados Mysql, e criar um banco de dados para ser utilizado no projeto.

<p style="color: red">OBS: Se atentar para não ter outra instancia de banco rodando na mesma porta</p>
<p style="color: red">OBS: Caso queira alterar o usuário e a senha de acesso ao banco, procurar o arquivo .env_mysql na 
pasta docker, localizada dentro da pasta src. Caso altere esses dados, é necessário também alterar
os arquivos .env que também estão de src.</p>

<ul>
    <li><em> cd .. (Para voltar a raiz do projeto) </em></li>
    <li><em> docker-compose up -d </em></li>
</ul>

Caso não tenha docker ou não deseje utilizar, você deve criar o banco diretamente no seu cliente de banco de dados
e colocar as strings de conexão no arquivo .env.

### EXECUTANDO AS MIGRATIONS:

Criado o banco e configurado o arquivo .env, é necessário rodas as migrations para gerar as tabelas necessárias para o projeto. No terminal digite o comando abaixo:
<ul>
    <li><em> php artisan migrate </em></li>
</ul>


## INICIANDO O SERVIDOR:

Para subir o servidor de aplicação, basta abrir o terminal e digitar o seguinte comando dentro da pasta src:

<ul>
    <li><em> php -S localhost:8000 -t public </em></li>
</ul>

Agora, você pode abrir qualquer ferramenta de sua preferência (ex: postman ou insomnia ) para consumir os endpoints
do projeto.

## COMO UTILIZAR:

Abaixo, segue os recursos para a utilização da api:

<h2> Endpoints de jornalistas </h2>
<strong>
<ul>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/register - Cria um novo jornalista
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/login - Autentica um jornalista
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/me - Retorna os dados do jornalista autenticado
    </li>

</ul>

<h2> Endpoints de notícias </h2>

<ul>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/new/create - Cria uma notícia
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/new/update/{id} - Edita uma notícia
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/new/delete/{id} - Exclui uma notícia
    </li>
    <li> 
        <a style="color: #34ce57">GET</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/news/me - Lista todas as notícias do jornalista autenticado
    </li>
    <li> 
        <a style="color: #34ce57">GET</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/news/type/{id} - Lista todas as notícias do jornalista autenticado pelo tipo de notícia
    </li>
</ul>

<h2> Endpoints de tipos de notícias </h2>

<ul>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/type/create - Cria um novo tipo de notícia
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/type/update/{id} - Edita um tipo de notícia
    </li>
    <li>
        <a style="color: #0062cc">POST</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/type/delete/{id} - Exclui um tipo de notícia ( Caso não tenha nenhuma notícia associada a este tipo)
    </li>
    <li> 
        <a style="color: #34ce57">GET</a> - 
        <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/api/type/me - Lista todas os tipos de notícia do jornalista autenticado
    </li>
</ul>
</strong>

## SWAGGER

Documentação da api no Swagger: <a style="color: white; background-color: #6f42c1; padding: 3px">host</a>/swagger
