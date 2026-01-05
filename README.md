## 🚀 Instalasi & Menjalankan Project

1️⃣ Clone Repository
git clone https://github.com/Jrieee/surat-keluar.git

2️⃣ Install Dependency Backend
composer install

3️⃣ Konfigurasi Environment
Salin file .env: cp .env.example .env

Generate application key: php artisan key:generate

Atur konfigurasi database pada file .env: 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surat-app
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Migrasi Database
Jalankan migration: php artisan migrate
Jalankan seeder: php artisan db:seed

5️⃣ Install Dependency Frontend
npm install
Jalankan Tailwind & Vite: npm run dev

6️⃣ Menjalankan Laravel
Buka terminal baru, lalu jalankan:  php artisan serve

🔄 Update Project (Pull Terbaru)
Untuk mengambil perubahan terbaru dari GitHub: git pull origin main
