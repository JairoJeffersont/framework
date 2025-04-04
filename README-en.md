
# 🧱 PHP Micro Framework - by Jairo Jefferson

A simple, lightweight, and 100% RESTful PHP micro framework built from scratch for learning, fast APIs, or small projects.

---

## ✅ Requirements

- PHP >= 8.0  
- Composer  
- Apache (with `.htaccess` support)  
- `mbstring` extension enabled  

---

## 🚀 Installation

1. Clone the repository:

```bash
git clone https://github.com/JairoJeffersont/framework.git your-project
cd your-project
```

2. Install the dependencies via Composer:

```bash
composer install
```

3. (Optional) Manually generate autoload if needed:

```bash
composer dump-autoload
```

---

## 🔧 Apache Configuration

Make sure Apache has `mod_rewrite` enabled.

Add this to your `.htaccess` (already included):

```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```

Set the DocumentRoot to the `public/` folder of the project.

---

## 🏁 Running the API

If you're using Apache with VirtualHost, just access it via browser or Postman:

```
GET http://localhost/
```

Or use PHP’s built-in server:

```bash
php -S localhost:8000 -t public
```

---

## 🧪 Route Examples

### 📦 API Status

```http
GET /
```

Returns:
```json
{
  "status": 200,
  "data": {
    "message": "Hello, the API is working, check the documentation"
  }
}
```

---

### 👥 List users

```http
GET /users
```

---

### ✍️ Create user (future example)

```http
POST /users
Content-Type: application/json

{
  "nome": "Jairo"
}
```

---

## 📃 License

MIT © [Jairo Jefferson](mailto:jairojeffersont@gmail.com)
