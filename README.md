# Teste técnico OnFly

Para este teste foi criado uma API Rest com Laravel, que conta com:
- Atenticação de usuário;
- CRUD de despesas;
- Envio de email para o usuário ao criar uma despesa;
- Restrições de acesso.

Para iniciar o projeto é preciso iniciar a aplicação com `php artisan serve` no terminal da aplicação, com isso ela por padrão irá iniciar para a url `http://127.0.0.1:8000` essa será a url utilizada para o acesso aos endpoints da aplicação.

Para iniciar as filas de processamento para o envio de e-mails é necessário iniciá-las com o comando `php artisan queue:work`.

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

2. Para obter as despesas é utilizado o endpoint `GET` `http://127.0.0.1:8000/api/despesas`, o retorno em JSON mostra as despesas do usuário.

3. Para obter uma única despesa é utilizado o endpoint `GET` `http://127.0.0.1:8000/api/despesas/{id}`, o retorno em JSON mostra as despesas do usuário.

4. Para excluir uma despesa é utilizado o endpoint `DELETE` `http://127.0.0.1:8000/api/despesas/{id}`.

5. Para atualizar uma despesa é utilizado o endpoint `PUT` ``http://127.0.0.1:8000/api/despesas/{id}`.
