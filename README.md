# 🌐 Fullstack Project - Portofolio Profile & Backoffice Panel

jika ingin mengakses secara online:
Backoffice: http://72.60.76.69:8282/login
Frontend Profile Contact Us: http://72.60.76.69:8283
https://github.com/CyanoCream/ContactMessage.git

Repo ini berisi **dua project**:

1. **Backend:** `backoffice-panel` (Laravel 12, PHP 8.3)
2. **Frontend:** `portofolio-profile` (NuxtJS 4.1)

---

## 📂 Struktur Folder

```
my-fullstack-app/
│
├── backoffice-panel/        # Project Laravel (Backend)
├── portofolio-profile/      # Project NuxtJS (Frontend)
└── README.md                # Panduan lengkap run project
```

---

## 🖥️ Backend - Laravel 12 (`backoffice-panel`)

### 1️⃣ Persyaratan

- PHP ≥ 8.3
- Composer
- Database: MySQL / PostgreSQL
- Node.js & NPM (untuk assets)

### 2️⃣ Instalasi

```bash
cd backoffice-panel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=UserSeeder
npm install
npm run dev
```

> Seeder akan membuat **akun admin default**:  
> Email: `admin@mail.com`  
> Password: `123`

### 3️⃣ Jalankan server

```bash
php artisan serve
```

Akses: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### 4️⃣ Build Mode

```bash
npm run build
php artisan optimize
```

---

## 🌐 Frontend - NuxtJS 4.1 (`portofolio-profile`)

### 1️⃣ Persyaratan

- Node.js ≥ 18
- NPM / Yarn
- Backend Laravel harus berjalan terlebih dahulu

### 2️⃣ Instalasi

```bash
cd portofolio-profile
npm install
cp .env.example .env
```

### 3️⃣ Konfigurasi Environment

Di `.env`, sesuaikan URL backend:

```env
NUXT_PUBLIC_API_BASE_URL=http://127.0.0.1:8000
```

> Sesuaikan host & port sesuai server Laravel saat dijalankan.

### 4️⃣ Jalankan Development Server

```bash
npm run dev
```

Akses: [http://localhost:3000](http://localhost:3000)

### 5️⃣ Build Production

```bash
npm run build
npm run preview
```

---

## 🔧 Tips

- Pastikan backend sudah jalan sebelum frontend agar API dapat diakses.
- Gunakan `.gitignore` untuk menghindari commit `node_modules`, `vendor`, dan file `.env`.

---

## 📄 Lisensi

MIT License

"# ContactMessage"
