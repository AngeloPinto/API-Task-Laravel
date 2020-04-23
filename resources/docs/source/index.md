---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://127.0.0.1:8000/docs/collection.json)

<!-- END_INFO -->

#Auth


<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## Registrar 
Registra um novo usuário

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Pedro","email":"email@email.com.br","password":"senha123"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Pedro",
    "email": "email@email.com.br",
    "password": "senha123"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "user": {
        "name": "rafael",
        "email": "rafael@gmail.com",
        "id": 4
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ]
    }
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

### HTTP Request
`POST api/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | O nome do usuário.
        `email` | string |  required  | O e-mail usuário.
        `password` | string |  required  | A senha de acesso para usuário.
    
<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## Login 
Efetua o login de um usuário

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"email@email.com.br","password":"teste123"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "email@email.com.br",
    "password": "teste123"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOl..."
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "Invalid Email or Password"
}
```

### HTTP Request
`POST api/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | E-mail do usuário.
        `password` | string |  required  | Senha do usuário.
    
<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_61739f3220a224b34228600649230ad1 -->
## Logout
Efetua o logout do usuário - invalida o token.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOi..."}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOi..."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "success": true,
    "message": "User logged out successfully"
}
```
> Example response (401):

```json
{
    "message": "The token has been blacklisted"
}
```

### HTTP Request
`POST api/logout`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `token` |  optional  | string required O token para cancelar.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `token` | string |  required  | O token para cancelar.
    
<!-- END_61739f3220a224b34228600649230ad1 -->

<!-- START_b19e2ecbb41b5fa6802edaf581aab5f6 -->
## Me
Lista dados do usuário logado com base no token

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/me" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/me"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "name": "nome_usuario",
    "email": "email@email.com.br"
}
```
> Example response (401):

```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/me`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `token` |  optional  | string required Token do usuário.

<!-- END_b19e2ecbb41b5fa6802edaf581aab5f6 -->

#Tasks


<!-- START_4227b9e5e54912af051e8dd5472afbce -->
## Todos
Lista todas as tarefas

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/tasks" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/tasks"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/tasks`


<!-- END_4227b9e5e54912af051e8dd5472afbce -->

<!-- START_4da0d9b378428dcc89ced395d4a806e7 -->
## Salvar

Salva uma nova tarefa

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/tasks" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/tasks"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/tasks`


<!-- END_4da0d9b378428dcc89ced395d4a806e7 -->

<!-- START_5297efa151ae4fd515fec2efd5cb1e9a -->
## Único
Exibe uma task específica

> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/tasks/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/tasks/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/tasks/{task}`


<!-- END_5297efa151ae4fd515fec2efd5cb1e9a -->

<!-- START_546f027bf591f2ef4a8a743f0a59051d -->
## Atualiza
Atualiza uma task específica

> Example request:

```bash
curl -X PUT \
    "http://127.0.0.1:8000/api/tasks/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/tasks/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/tasks/{task}`

`PATCH api/tasks/{task}`


<!-- END_546f027bf591f2ef4a8a743f0a59051d -->

<!-- START_8b8069956f22facfa8cdc67aece156a8 -->
## Deletar
Deleta uma task específica

> Example request:

```bash
curl -X DELETE \
    "http://127.0.0.1:8000/api/tasks/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/tasks/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/tasks/{task}`


<!-- END_8b8069956f22facfa8cdc67aece156a8 -->


