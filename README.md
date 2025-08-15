# 📚 Book Catalog Dashboard (Laravel + Filament V3)

Sebuah aplikasi web dashboard berbasis Laravel & Filament untuk mengelola koleksi buku, penulis, kategori, statistik rating, dan menampilkan buku paling populer secara real time.

---

## ✨ Fitur Utama

- Manajemen **Books**, **Authors**, dan **Categories**
- Dashboard Filament dengan **statistik total** & **average rating**
- Rating sistem real-time dari tabel `ratings`
- Auto-login saat development (ENV local)
- API endpoint untuk data buku (optional)

---

## ⚙️ Spesifikasi

| Technology | Version |
|------------|---------|
| Laravel    | ^10.x   |
| PHP        | ^8.1 / 8.2 |
| Filament   | ^3.x    |
| MySQL      | 5.7+    |

---

## 🚀 Instalasi

1. **Clone repository📂**

```bash
git clone <your-repo-link>
cd your-project
````

2. **Install Composer dependencies**

```bash
composer install
```

3. **Copy .env & Generate Key**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Setup Database**

buat database dengan nama yang di sesauikan dengan `DB_DATABASE` atau bisa menggunakan default dengan nama `laravel`

Edit file `.env`:

```
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

Kemudian jalankan migrasi + seeder jika ada:

```bash
php artisan migrate --seed
```

5. **Auto-login (Development Only)**
   Jika `APP_ENV=local`, maka user dengan ID=1 akan otomatis login ke dashboard Filament.

Yakinkan dulu user id 1 ada:

```bash
php artisan tinker
>>> \App\Models\User::factory()->create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
])
```

6. **Jalankan aplikasi**

```bash
php artisan serve
```

Akses: `http://localhost:8000` akan redirect ke `/admin`.

---

## 🐳 Jika dijalankan dengan Docker (Opsional)

Jika kamu ingin menjalankan aplikasi tanpa install PHP atau Composer di lokal, cukup gunakan Docker.

1. **Build image**

```bash
docker build -t php8:2 .
```

2. **Jalankan dengan docker-compose**

```bash
docker compose up -d
```

Aplikasi akan berjalan di `http://localhost:8000` atau sesuai port di `docker-compose.yml`.

---

## 🔑 Login (Production Mode)

Jika kamu ubah `.env` menjadi `APP_ENV=production`, maka login akan aktif normal:

```
Email: admin@example.com
Password: password
```

---

## 🧪 Testing API (Opsional)

```bash
GET /api/books
GET /api/books/{id}
```

---

## ❤️ Credits

Developed using:

* **Laravel** PHP Framework
* **Filament v3** Admin Panel
* Tailwind CSS, AlpineJS
* Designed by: *\[Tarisahmdj]* 👨‍💻

---

> Feel free to fork, contribute, or request new features!
>
> *Enjoy building awesome dashboards 🚀*