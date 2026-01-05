# 🔧 Quick Reference - Command Penting

## Database Setup

```bash
# Run semua migrations
php artisan migrate

# Rollback migrations (hati-hati!)
php artisan migrate:rollback

# Fresh migration + seeding
php artisan migrate:fresh --seed

# Create storage link untuk file upload
php artisan storage:link

# Seed database dengan test data
php artisan db:seed
```

## Development

```bash
# Start development server
php artisan serve

# Compile assets (Vite)
npm run dev

# Build untuk production
npm run build

# Clear all cache
php artisan optimize:clear
```

## Testing

```bash
# Run PHPUnit tests
php artisan test

# Run tests dengan coverage
php artisan test --coverage
```

## Artisan Commands Umum

```bash
# Clear cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Generate app key (jika belum ada)
php artisan key:generate
```

## Database Tinker (Interactive Shell)

```bash
php artisan tinker

# Di dalam tinker:
App\Models\User::all();
App\Models\SuratKeluar::count();
App\Models\User::where('role', 'admin')->first();
```

## File Upload Path

```
File disimpan di: storage/app/public/surat-keluars/
Accessible via: /storage/surat-keluars/{filename}
```

## Useful Routes untuk Testing

```
/ - Welcome page
/login - Login page
/dashboard - Dashboard (role-based)
/surat-keluars - List surat
/surat-keluars/create - Create surat
/users - User management (admin only)
/profile - Edit profile
```

## Common Issues & Solutions

### Issue: Storage link not working
```bash
php artisan storage:link
```

### Issue: Migrations not found
```bash
composer dump-autoload
php artisan migrate
```

### Issue: Permission denied on storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: View cache invalid
```bash
php artisan view:clear
php artisan cache:clear
```

## Environment Variables (.env)

```
APP_NAME=SuratKeluar
APP_ENV=local
APP_DEBUG=true
APP_KEY=your-app-key-here

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=surat_keluar
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

## Test Credentials

| Account | Email | Password |
|---------|-------|----------|
| Admin | admin@surat-app.test | password123 |
| Staff 1 | staff1@surat-app.test | password123 |
| Staff 2 | staff2@surat-app.test | password123 |

---

Untuk info lebih lengkap, baca SETUP_GUIDE.md
