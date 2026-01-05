# 📋 Aplikasi Surat Keluar - Dokumentasi Setup & Testing

## ✅ Fitur Utama

### 1. Database Schema
- ✅ Users Table dengan kolom `role` (enum: 'admin', 'staff')
- ✅ SuratKeluars Table dengan kolom lengkap
- ✅ Relationships & Indexes

### 2. Hak Akses (Permissions)
- ✅ Admin: CRUD Surat Keluar + Manajemen User (tidak bisa self-delete)
- ✅ Staff: CRUD Surat Keluar sendiri + lihat dashboard sendiri
- ✅ Policies & Middleware untuk authorization

### 3. Layout & UI
- ✅ Sidebar Modern (Fixed Left, Responsive)
- ✅ Dashboard berbeda untuk Admin & Staff
- ✅ Menu dinamis berdasarkan role

### 4. Controllers
- ✅ DashboardController (logic berbeda per role)
- ✅ SuratKeluarController (CRUD + download file)
- ✅ UserController (manage user untuk admin)

### 5. Views
- ✅ Layout app.blade.php (sidebar modern)
- ✅ Dashboard Admin (stats, recent surat, user list)
- ✅ Dashboard Staff (stats, recent surat sendiri)
- ✅ Surat Keluar CRUD (index, create, edit, show)
- ✅ User Management (index, show)

---

## 🚀 SETUP PETUNJUK

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Create Storage Link untuk File Upload
```bash
php artisan storage:link
```

### Step 3: Seed Database dengan Test Data
```bash
php artisan db:seed
```

### Step 4: Start Development Server
```bash
php artisan serve
```

### Step 5: Buka di Browser
```
http://localhost:8000
```

---

## 👤 Test Account Credentials

### Admin Account
- **Email**: admin@surat-app.test
- **Password**: password123
- **Role**: Admin

### Staff Account 1
- **Email**: staff1@surat-app.test
- **Password**: password123
- **Role**: Staff

### Staff Account 2
- **Email**: staff2@surat-app.test
- **Password**: password123
- **Role**: Staff

---

## 📝 Testing Checklist

### Dashboard
- [ ] Login dengan Admin → Dashboard Admin muncul
- [ ] Login dengan Staff → Dashboard Staff muncul
- [ ] Admin melihat: Total Surat, Total Staff, Recent Surats, User List
- [ ] Staff melihat: Total Surat Saya, Recent Surat Saya

### Surat Keluar - CRUD
- [ ] Create: Buat surat keluar baru (dengan file PDF)
- [ ] Read: Lihat detail surat keluar
- [ ] Update: Edit surat keluar, ganti file
- [ ] Delete: Hapus surat keluar
- [ ] Download: Download file surat
- [ ] Admin bisa lihat semua surat, Staff hanya miliknya

### User Management (Admin Only)
- [ ] Admin bisa lihat daftar user
- [ ] Admin bisa lihat detail user + statistik surat
- [ ] Admin bisa hapus user (staff)
- [ ] Admin tidak bisa hapus dirinya sendiri (error message)
- [ ] Staff tidak bisa akses user management page

### Sidebar & Navigation
- [ ] Sidebar responsive (collapse di mobile)
- [ ] Menu "Manajemen User" hanya muncul untuk Admin
- [ ] Active menu indicator (highlight)
- [ ] User profile info & logout button di sidebar

### Validasi & Error Handling
- [ ] Validasi input form (nomor surat, tanggal, dll)
- [ ] File upload hanya PDF, max 5MB
- [ ] Flash messages (success, error) muncul
- [ ] Error validation messages ditampilkan

### Authorization
- [ ] Staff tidak bisa akses route admin
- [ ] Staff tidak bisa edit/delete surat staff lain
- [ ] Admin bisa edit/delete surat siapa saja

---

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── SuratKeluarController.php
│   │   └── UserController.php
│   ├── Middleware/
│   │   └── IsAdmin.php
│   └── Requests/
│       ├── StoreSuratKeluarRequest.php
│       └── UpdateSuratKeluarRequest.php
├── Models/
│   ├── User.php (updated)
│   └── SuratKeluar.php
├── Policies/
│   ├── SuratKeluarPolicy.php
│   └── UserPolicy.php
└── Providers/
    └── AppServiceProvider.php (updated)

database/
├── migrations/
│   ├── 2025_12_29_000001_add_role_to_users_table.php
│   └── 2025_12_29_000002_create_surat_keluars_table.php
└── seeders/
    └── DatabaseSeeder.php (updated)

resources/views/
├── layouts/
│   └── app.blade.php (updated - sidebar)
├── dashboard/
│   ├── admin.blade.php
│   └── staff.blade.php
├── surat-keluars/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── users/
    ├── index.blade.php
    └── show.blade.php

routes/
└── web.php (updated)

bootstrap/
└── app.php (updated - middleware alias)
```

---

## 🎨 Fitur Design

### Sidebar
- Gradient blue (from-blue-900 to-blue-800)
- Fixed left layout
- Responsive (collapse di mobile)
- User profile section
- Navigation menu dinamis

### Colors & Styling
- **Primary**: Blue (#2563eb, #1e40af)
- **Success**: Green (#16a34a)
- **Warning**: Yellow (#ca8a04)
- **Danger**: Red (#dc2626)
- **Background**: Gray (#f3f4f6)

### Components
- Cards dengan shadow
- Tables dengan hover effect
- Forms dengan validation styling
- Buttons dengan hover state
- Flash messages (alert boxes)
- Pagination

---

## 🔒 Security Features

- ✅ CSRF Protection
- ✅ Authorization Policies
- ✅ Role-based Access Control
- ✅ File upload validation (PDF only)
- ✅ User self-deletion prevention
- ✅ Password hashing

---

## 💡 Notes

1. **File Upload**: File disimpan di `storage/app/public/surat-keluars/`
2. **Database**: Gunakan migration untuk schema consistency
3. **Roles**: Admin dan Staff, tidak ada role dinamis
4. **Permissions**: Check di Policy files untuk custom logic
5. **Validasi**: Lihat FormRequest files untuk rules

---

## 🚨 Troubleshooting

### Sidebar tidak muncul responsive
- Pastikan JavaScript di layout.blade.php berjalan
- Check browser console untuk error

### File upload error
- Pastikan sudah run `php artisan storage:link`
- Check permissions folder `storage/app/public`

### Migration error
- Pastikan menggunakan PHP 8.1+
- Check .env file konfigurasi database

### Login error
- Pastikan sudah run seeder: `php artisan db:seed`
- Email harus sesuai dengan test credentials

---

Selamat! Aplikasi Surat Keluar sudah siap digunakan! 🎉
