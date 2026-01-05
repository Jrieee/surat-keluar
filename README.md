## 🚀 Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal.

### 1️⃣ Clone & Setup Awal
Jalankan perintah ini berurutan di terminal (Git Bash / CMD):

```bash
# Clone repository dan masuk ke folder
git clone https://github.com/Jrieee/surat-keluar.git

# Install dependency backend
composer install

# Setup file environment
cp .env.example .env
php artisan key:generate
```

### 2️⃣ Konfigurasi Database
Buka file .env lalu sesuaikan bagian database (pastikan database surat-app sudah dibuat di MySQL):
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surat-app
DB_USERNAME=root
DB_PASSWORD=

#Setelah itu, jalankan migrasi dan seeder data:
php artisan migrate --seed
```

### 3️⃣ Setup Frontend & Menjalankan Server
Install dependency frontend dan jalankan server:
```bash
# Install package Node.js
npm install

# Jalankan Vite (biarkan terminal ini terbuka)
npm run dev

# Buka terminal baru, lalu jalankan server Laravel:
php artisan serve
