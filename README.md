# Marmita Cori - Microserviço REST

Este projeto é um microserviço REST para controle de entrega de marmitas em uma instituição, com interface web para consulta do cardápio do dia por tipo de usuário.

## Sumário
- [Requisitos](#requisitos)
- [Instalação e Configuração](#instalacao)
- [Banco de Dados](#banco)
- [API REST](#api)
- [Documentação OpenAPI (Swagger)](#openapi)
- [Frontend (Interface Web)](#frontend)

<a name="requisitos"></a>
## Requisitos
- PHP 7.4+
- MySQL 5.7+
- Servidor web (Apache recomendado)

<a name="instalacao"></a>
## Instalação e Configuração
1. Clone ou copie este repositório para o diretório do seu servidor web.
2. Configure o acesso ao banco de dados em `api.php` (usuário, senha, nome do banco).
3. Importe a estrutura do banco de dados:
	 - No MySQL, execute o script `estrutura_banco.sql`:
		 ```sql
		 SOURCE estrutura_banco.sql;
		 ```
4. Inicie o servidor web e acesse a API ou o frontend pelo navegador.

<a name="banco"></a>
## Banco de Dados
O script `estrutura_banco.sql` cria as seguintes tabelas:
- `user_type`: Tipos de usuário (ex: estudante, servidor)
- `user`: Usuários
- `menu`: Datas de cardápio
- `menu_option`: Opções de cardápio por data e tipo de usuário
- `delivery`: Registro de entregas

<a name="api"></a>
## API REST
O endpoint principal é `api.php`. Os recursos disponíveis são:

### Tipos de Usuário
- `GET /api.php/user_type` — Lista tipos de usuário
- `POST /api.php/user_type` — Cria tipo de usuário `{ "name": "estudante" }`

### Usuários
- `GET /api.php/user` — Lista usuários
- `POST /api.php/user` — Cria usuário `{ "name": "João", "user_type_id": 1 }`

### Menu (Datas)
- `GET /api.php/menu` — Lista datas de menu
- `POST /api.php/menu` — Cria data de menu `{ "date": "2025-10-24" }`

### Opções de Cardápio
- `GET /api.php/menu_option?menu_id=1&user_type_id=2` — Lista opções para a data e tipo de usuário
- `POST /api.php/menu_option` — Cria opção `{ "menu_id": 1, "user_type_id": 2, "description": "Peixe frito" }`

### Entregas
- `GET /api.php/delivery` — Lista entregas
- `POST /api.php/delivery` — Registra entrega `{ "user_id": 1, "menu_option_id": 2 }`

As respostas são sempre em JSON. Para detalhes completos dos parâmetros e respostas, consulte a documentação OpenAPI abaixo.

<a name="openapi"></a>
## Documentação OpenAPI (Swagger)
A especificação OpenAPI está disponível no arquivo [`openapi.yaml`](openapi.yaml). Você pode visualizar em ferramentas como [Swagger Editor](https://editor.swagger.io/):

1. Acesse https://editor.swagger.io/
2. Clique em "File" > "Import File" e selecione o arquivo `openapi.yaml` deste projeto.

<a name="frontend"></a>
## Frontend (Interface Web)
O diretório `frontend/` contém a página `index.html` para consulta do cardápio do dia:

1. Acesse `frontend/index.html` pelo navegador.
2. Selecione a data do menu e o tipo de usuário.
3. Clique em "Consultar Cardápio" para ver as opções disponíveis para aquele dia e usuário.

### Fluxo de Utilização
1. Cadastre tipos de usuário (`user_type`).
2. Cadastre usuários (`user`).
3. Cadastre datas de menu (`menu`).
4. Cadastre opções de cardápio para cada data e tipo de usuário (`menu_option`).
5. Consulte o cardápio pelo frontend ou pela API.
6. Registre entregas conforme necessário (`delivery`).

---
Em caso de dúvidas, consulte o código-fonte ou a especificação OpenAPI.
# marmita-cori
Sistema para controlar entrega de marmita no Campus Oriximiná
