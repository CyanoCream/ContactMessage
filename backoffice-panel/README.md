# 🖥️ **Backoffice Panel - Laravel Project**

Sistem **Backoffice Panel** berbasis **Laravel 12** dengan autentikasi menggunakan **Laravel Breeze (Blade)**.  
Proyek ini menyediakan dasar yang kuat untuk sistem admin dengan fitur login, register, dan manajemen data.

---

## 🚀 **Panduan Instalasi**

### 1️⃣ Clone atau Download Project

```bash
git clone 
cd backoffice-panel
```

---

### 2️⃣ Install Dependencies via Composer

```bash
composer install
```

> ⚠️ **Catatan:**  
> Jika muncul error seperti:
>
> ```
> Your requirements could not be resolved...
> ```
>
> Tambahkan dua baris berikut di bawah bagian `"license"` di file `composer.json`:
>
> ```json
> "minimum-stability": "dev",
> "prefer-stable": true,
> ```
>
> Lalu jalankan ulang:
>
> ```bash
> composer install
> ```

---

### 3️⃣ Setup File Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Lalu sesuaikan konfigurasi database Anda di file `.env`.

---

### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

---

### 5️⃣ Migrasi Database

```bash
php artisan migrate
```

---

### 6️⃣ Jalankan Seeder (Buat User Admin Default)

Seeder akan otomatis membuat akun admin bawaan:

- **Email:** `admin@mail.com`
- **Password:** `123`

```bash
php artisan db:seed --class=UserSeeder
```

Atau untuk reset database dan seed ulang:

```bash
php artisan migrate:fresh --seed
```

---

### 7️⃣ Install Frontend Dependencies

```bash
npm install
npm run dev
```

> 💡 Gunakan `npm run build` untuk mode produksi.

---

### 8️⃣ Optimasi Aplikasi

```bash
php artisan optimize
```

---

### 9️⃣ Jalankan Server

```bash
php artisan serve
```

Akses aplikasi melalui: [http://localhost:8000](http://localhost:8000)

---

---

## 🧠 **Informasi Tambahan**

- Framework: **Laravel 12**
- Frontend: **Laravel Breeze (Blade)**
- Database: **MySQL / PostgreSQL**
- Tools: **Composer**, **NPM**, **Artisan CLI**

---

### ✨ **Kontributor**

Dibuat dengan ❤️ oleh **Tim Developer Backoffice**

---

### 📄 **Lisensi**

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
