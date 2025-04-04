# Framework PHP

Um micro framework PHP criado com foco em **simplicidade**, **leveza** e **organização**. Ideal para quem quer desenvolver aplicações web modernas sem a complexidade de grandes frameworks.

### ✨ Funcionalidades:
- Estrutura MVC clara e objetiva
- Sistema de rotas simples
- Suporte a middlewares
- Carregamento automático de classes (autoload)
- Fácil integração com banco de dados

### 🚀 Por que usar?
- Código limpo e fácil de entender
- Ótimo para estudos ou projetos pequenos/médios
- Sem dependências externas pesadas

## ✅ Requisitos

- PHP >= 8.0
- Composer
- Apache (com suporte a `.htaccess`)
- Extensão `mbstring` habilitada

---

## 🚀 Instalação

1. Clone o repositório:

```bash
git clone https://github.com/JairoJeffersont/framework.git seu-projeto
cd seu-projeto
```

2. Instale as dependências via Composer:

```bash
composer install
```

3. (Opcional) Gere o autoload manualmente se necessário:

```bash
composer dump-autoload
```

---

## 🔧 Configuração do Apache

Certifique-se que o Apache tem o `mod_rewrite` habilitado.

Adicione no seu `.htaccess` (já incluso):

```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```

Aponte o DocumentRoot para a pasta `public/` do projeto.

---

## 🔧 Configuração do .env

Adicione os dados do banco de dados no seu arquivo `.env` (já incluso):

```
DB_HOST=localhost
DB_NAME=db_name
DB_USER=root
DB_PASS=root
```

---

## 🏁 Rodando a API

Se estiver usando Apache com VirtualHost, só acessar no navegador ou via Postman:

```
GET http://localhost/
```

Ou usar o servidor embutido do PHP:

```bash
php -S localhost:8000 -t public
```

---

## 🧪 Exemplos de Rotas

### 📦 Status da API

```http
GET /
```

Retorna:
```json
{
  "status": 200,
  "data": {
    "message": "Hello, the API is working, check the documentation"
  }
}
```

---

### 👥 Listar usuários

```http
GET /users
```

---

### ✍️ Criar usuário (exemplo para futuro)

```http
POST /users
Content-Type: application/json

{
  "nome": "Jairo"
}
```

---


## 📃 Licença

MIT © [Jairo Jefferson](mailto:jairojeffersont@gmail.com)
