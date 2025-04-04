# 🧱 Micro Framework PHP - by Jairo Jefferson

Um micro framework PHP simples, leve e 100% RESTful, feito do zero para estudos, APIs rápidas ou projetos pequenos.

---

## ✅ Requisitos

- PHP >= 8.0
- Composer
- Apache (com suporte a `.htaccess`)
- Extensão `mbstring` habilitada

---

## 🚀 Instalação

1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/seu-projeto.git
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

### 📁 Enviar arquivos

```http
POST /api/upload
Content-Type: multipart/form-data
file: [arquivo]
```

---

## 📁 Estrutura de Pastas

```
.
├── public/           # Entrada principal (index.php)
├── routes/           # Definição de rotas (modularizadas)
│   └── api/
├── src/
│   ├── App.php       # Núcleo do framework
│   ├── Controllers/  # Controllers REST
│   ├── Models/       # Modelos de dados
│   └── Utils/        # Helpers e funções úteis
├── composer.json
└── README.md
```

---

## 📃 Licença

MIT © [Jairo Jefferson](mailto:jairojeffersont@gmail.com)
