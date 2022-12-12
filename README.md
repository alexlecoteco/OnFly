# Teste técnico OnFly

Para este teste foi criado uma API Rest com Laravel, que conta com:
- Atenticação de usuário;
- CRUD de despesas;
- Envio de email para o usuário ao criar uma despesa;
- Restrições de acesso.

Para iniciar o projeto é preciso iniciar a aplicação com `php artisan serve` no terminal da aplicação, com isso ela por padrão irá iniciar para a url `http://127.0.0.1:8000` essa será a url utilizada para o acesso aos endpoints da aplicação.

Para iniciar as filas de processamento para o envio de e-mails é necessário iniciá-las com o comando `php artisan queue:work`.

Como o banco de dados foi enviado para o arquivo do git, rodando o `composer install` já deve ser o sufiente para utilizar a aplicação. **Observação** é interessante rodar o comando `php artisan migrate:refresh` para que as migrations sejam aplicadas e o banco resetado.

Mas caso seja interessante utilizar outro banco de dados é necessário alterar em `.env` os dados de banco de dados e rodar o comando `php artisan migrate`.

## Login e Autenticação

Para acessar um usuário é necessário primeiramente registrá-lo, para isso é utilizado o endpoint `POST` `http://127.0.0.1:8000/api/register` e nele inserir o JSON com o seguinte formato `{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
}`.

Para obter o token de autenticação JWT é necessário acessar o endpoint `POST` `http://127.0.0.1:8000/api/login` e inserir o JSON com o seguinte formato `{
    "email": "test@example.com",
    "password": "password"
}`. Com isso é recebido no corpo da resposta o Token JWT que será necessário para a autenticação dos endpoints de despesas. Ex: `"1|NvYFeFGwe4mDSd3LipJKv0fPVPm9piR4FC2NOiQl"`

## Endpoints de Despesa

**Importante:** Para acessar qualquer endpoint de despesa é preciso utilizar a Authorização por Bearer Token, que é o token recebido ao realizar o login, como foi explicado acima.

1. Para criar uma despesa é preciso acessar o endpoint `POST` `http://127.0.0.1:8000/api/despesas` e inserir o JSON com o seguinte formato `{
    "data": "2022-12-9",
    "valor": 25250.18,
    "descricao": "Carro Novo"
}`, o id do usuário já é armazenado de acordo com o token utilizado. Ao criar uma despesa é realizado o envio de um e-mail para o usuário logado.

2. Para obter as despesas é utilizado o endpoint `GET` `http://127.0.0.1:8000/api/despesas`, o retorno em JSON mostra as despesas do usuário. **OBS** foi utilizado o método `paginate()` para a busca de dados, então são mostrados alguns valores pertinentes a busca de outras páginas ou de informações nesse GET.

3. Para obter uma única despesa é utilizado o endpoint `GET` `http://127.0.0.1:8000/api/despesas/{id}`, o retorno em JSON mostra as despesas do usuário.

4. Para excluir uma despesa é utilizado o endpoint `DELETE` `http://127.0.0.1:8000/api/despesas/{id}`.

5. Para atualizar uma despesa é utilizado o endpoint `PUT` `http://127.0.0.1:8000/api/despesas/{id}`.

## Envio de emails

Para realizar o envio de emails foi utilizado o mailtrap para que fosse realizado os testes, para isso foi utilizado as credenciais do mailtrap no .env `MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=ce47e455a44c9b
MAIL_PASSWORD=dfbb498be083e8
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"` caso seja necessário é possível utilizar a ferramenta mailtrap para também realizar os testes, criando a conta e trocando o MAIL_USERNAME e o MAIL_PASSWORD.
