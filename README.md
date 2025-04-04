# Framework PHP

A micro framework PHP created with a focus on simplicity, lightness, and organization. Ideal for those who want to develop modern web applications without the complexity of large frameworks.

### ✨ Features:
- Clear and straightforward MVC structure  
- Simple routing system  
- Middleware support  
- Automatic class loading (autoload)  
- Easy database integration

### 🚀 Why use it?
- Clean and easy-to-understand code  
- Great for learning or small/medium projects  
- No heavy external dependencies

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

3. (Optional) Generate the autoload manually if needed:

```bash
composer dump-autoload
```

---

## 🔧 Apache Configuration

Make sure Apache has `mod_rewrite` enabled.

Add the following to your `.htaccess` file (already included):

```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```

Point the DocumentRoot to the project's public/ folder.

---

## 🔧 .env Configuration

Add your database details to the `.env` file (already included):

```
DB_HOST=localhost
DB_NAME=db_name
DB_USER=root
DB_PASS=root
```

---

## 🏁 Running the API

If you're using Apache with a VirtualHost, just access it via browser or Postman:

```
GET http://localhost/
```

Or use PHP's built-in server:

```bash
php -S localhost:8000 -t public
```

---

## 🧪 Route Examples

### 📦 API Status

```http
GET /
```

Return:
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

### ✍️ Create new user 

```http
POST /users
Content-Type: application/json

{
  "name": "Jairo"
}
```

---


## 📝 License

This project is licensed under the **MIT License** – feel free to use, modify, and distribute it as you like.

MIT © [Jairo Jefferson](mailto:jairojeffersont@gmail.com)
