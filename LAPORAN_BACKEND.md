# 📋 LAPORAN BACKEND - SURAT KELUAR SYSTEM

## 1. 📊 MODELS (Database Structure & Logic)

### 1.1 User Model
**Lokasi:** `app/Models/User.php`

```php
<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Atribut yang bisa diisi (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // admin atau pegawai
    ];

    // Hidden attributes saat serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Type casting
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship: User punya banyak Surat Keluar
    public function suratKeluars()
    {
        return $this->hasMany(SuratKeluar::class);
    }

    // Helper method untuk pengecekan role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }
}
```

**Fitur:**
- Extend dari `Authenticatable` untuk autentikasi
- Role-based: admin & pegawai
- Relationship dengan SuratKeluar (1:Many)

---

### 1.2 SuratKeluar Model
**Lokasi:** `app/Models/SuratKeluar.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluars';

    protected $fillable = [
        'user_id',
        'nomor_surat',
        'nomor_urut',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'alamat_penerima',
        'file_surat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    // Relationship: Surat Keluar punya 1 User (Pembuat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk path file
    public function getFilePathAttribute()
    {
        return $this->file_surat ? storage_path('app/public/' . $this->file_surat) : null;
    }
}
```

**Fitur:**
- Menyimpan data surat keluar
- Relationship dengan User
- Support untuk file attachment

---

## 2. 🎮 CONTROLLERS (Business Logic)

### 2.1 SuratKeluarController
**Lokasi:** `app/Http/Controllers/SuratKeluarController.php`

**Metode Utama:**

```php
// INDEX - Menampilkan daftar surat keluar
public function index()
{
    $user = auth()->user();
    $search = request()->input('search');
    
    // Admin lihat semua, Pegawai hanya miliknya
    $query = $user->isAdmin() 
        ? SuratKeluar::with('user')
        : $user->suratKeluars();

    // Filter search by nomor_surat, perihal, tujuan, alamat
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nomor_surat', 'like', '%' . $search . '%')
              ->orWhere('perihal', 'like', '%' . $search . '%')
              ->orWhere('tujuan', 'like', '%' . $search . '%')
              ->orWhere('alamat_penerima', 'like', '%' . $search . '%');
        });
    }

    $suratKeluars = $query->orderBy('nomor_urut')->paginate(10);

    return view('surat-keluars.index', [
        'suratKeluars' => $suratKeluars,
        'isAdmin' => $user->isAdmin(),
        'search' => $search,
    ]);
}

// CREATE, STORE, EDIT, UPDATE, DESTROY, DOWNLOAD
```

**Fitur:**
- CRUD untuk Surat Keluar
- Filter & Search
- Download file
- Role-based access (Admin vs Pegawai)
- Automatic numbering (`nomor_urut`)

---

### 2.2 UserController
**Lokasi:** `app/Http/Controllers/UserController.php`

```php
public function index()
{
    $this->authorize('viewAny', User::class);  // Policy check
    $users = User::latest()->paginate(10);
    return view('users.index', ['users' => $users]);
}

public function show(User $user)
{
    $this->authorize('view', $user);
    return view('users.show', ['user' => $user]);
}

public function destroy(User $user)
{
    $this->authorize('delete', $user);
    
    // Prevent self-deletion
    if ($user->id === auth()->id()) {
        return back()->withErrors(['error' => 'Cannot delete yourself']);
    }
    
    $user->delete();
    return redirect()->route('users.index');
}
```

**Fitur:**
- Hanya Admin yang bisa akses
- Menggunakan Policies untuk authorization
- List, Show, Delete users
- Prevent self-deletion

---

### 2.3 DashboardController
**Lokasi:** `app/Http/Controllers/DashboardController.php`

```php
public function index()
{
    $user = auth()->user();

    if ($user->isAdmin()) {
        // Dashboard Admin - Statistik keseluruhan
        $totalSurat = SuratKeluar::count();
        $totalPegawai = User::where('role', 'pegawai')->count();
        $recentSurats = SuratKeluar::latest()->take(5)->get();
        $allUsers = User::all();

        return view('dashboard.admin', [
            'totalSurat' => $totalSurat,
            'totalPegawai' => $totalPegawai,
            'recentSurats' => $recentSurats,
            'allUsers' => $allUsers,
        ]);
    } else {
        // Dashboard Pegawai - Statistik pribadi
        $recentSurats = $user->suratKeluars()->latest()->take(5)->get();
        $totalSuratUser = $user->suratKeluars()->count();

        return view('dashboard.pegawai', [
            'recentSurats' => $recentSurats,
            'totalSuratUser' => $totalSuratUser,
        ]);
    }
}
```

**Fitur:**
- Dynamic dashboard berdasarkan role
- Admin: statistik semua sistem
- Pegawai: statistik pribadi

---

### 2.4 ProfileController & Auth Controllers
**Lokasi:** `app/Http/Controllers/ProfileController.php`

- Edit, Update, Delete profil user
- Built-in Laravel Breeze auth controllers di `app/Http/Controllers/Auth/`

---

## 3. 🛣️ ROUTING (API Endpoints & Routes)

### 3.1 Main Routes (Web)
**Lokasi:** `routes/web.php`

```php
<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;

// Root route - redirect ke dashboard jika sudah login
Route::get('/', function () {
    if (auth('web')->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Protected routes (memerlukan auth)
Route::middleware('auth')->group(function () {
    
    // Dashboard dengan role-based logic
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    
    // Surat Keluar CRUD (accessible by Admin & Pegawai)
    Route::resource('surat-keluars', SuratKeluarController::class);
    
    // Custom action untuk download file
    Route::get('surat-keluars/{suratKeluar}/download', 
        [SuratKeluarController::class, 'download'])
        ->name('surat-keluars.download');
    
    // User Management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)
            ->except(['create', 'store', 'edit', 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });
});

// Auth routes (login, register, password reset)
require __DIR__.'/auth.php';
```

**Endpoints Summary:**
| Method | Route | Controller | Purpose |
|--------|-------|-----------|---------|
| GET | / | - | Root redirect |
| GET | /dashboard | DashboardController@index | Dashboard |
| GET\|PATCH\|DELETE | /profile | ProfileController | Profile management |
| GET\|POST | /surat-keluars | SuratKeluarController | List & Create |
| GET | /surat-keluars/{id} | SuratKeluarController@show | Detail |
| GET | /surat-keluars/{id}/edit | SuratKeluarController@edit | Edit form |
| PUT\|PATCH | /surat-keluars/{id} | SuratKeluarController@update | Update |
| DELETE | /surat-keluars/{id} | SuratKeluarController@destroy | Delete |
| GET | /surat-keluars/{id}/download | SuratKeluarController@download | Download file |
| GET | /users | UserController@index | List users (Admin only) |
| GET | /users/{id} | UserController@show | Detail user (Admin only) |
| DELETE | /users/{id} | UserController@destroy | Delete user (Admin only) |

---

### 3.2 Auth Routes
**Lokasi:** `routes/auth.php`

```php
<?php
// Guest routes (tanpa login)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    // ... other verified email routes
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
```

---

## 4. 🗄️ DATABASE MIGRATION (Schema)

### 4.1 Users Table
**Lokasi:** `database/migrations/0001_01_01_000000_create_users_table.php`

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();  // created_at, updated_at
});
```

---

### 4.2 Add Role to Users
**Lokasi:** `database/migrations/2025_12_29_000001_add_role_to_users_table.php`

```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['admin', 'Pegawai'])
        ->default('staff')
        ->after('email');
});
```

**Note:** Dalam kode actual, role yang digunakan adalah 'admin' dan 'pegawai' (bukan 'staff' pada migration lama)

---

### 4.3 Surat Keluars Table
**Lokasi:** `database/migrations/2025_12_29_000002_create_surat_keluars_table.php`

```php
Schema::create('surat_keluars', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')
        ->constrained('users')
        ->onDelete('cascade');  // Jika user dihapus, surat juga dihapus
    
    $table->string('nomor_surat')->unique();
    $table->date('tanggal_surat');
    $table->string('tujuan');
    $table->string('perihal');
    $table->text('alamat_penerima');
    $table->string('file_surat')->nullable();
    $table->timestamps();  // created_at, updated_at
    
    // Indexes untuk performa query
    $table->index('nomor_surat');
    $table->index('tanggal_surat');
    $table->index('user_id');
});
```

---

### 4.4 Additional Migrations
**Lokasi:** `database/migrations/`

- `2026_01_05_add_nomor_urut_to_surat_keluars_table.php` - Add numbering
- `2026_01_05_renumber_surat_keluars.php` - Renumbering data
- `2026_01_07_add_waktu_surat_to_surat_keluars_table.php` - Add time field
- `2026_01_07_remove_waktu_surat_from_surat_keluars_table.php` - Remove time field
- `2026_01_08_change_staff_to_pegawai.php` - Change role name to pegawai

---

## 5. 🔐 AUTHENTICATION & AUTHORIZATION

### 5.1 Authentication Guard
**Lokasi:** `config/auth.php`

```php
'defaults' => [
    'guard' => env('AUTH_GUARD', 'web'),  // Session-based auth
    'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

**Tipe:** Session-based authentication (built-in Laravel Breeze)

---

### 5.2 Middleware: IsAdmin
**Lokasi:** `app/Http/Middleware/IsAdmin.php`

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN memiliki role admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
```

**Penggunaan:**
```php
Route::middleware('admin')->group(function () {
    // Routes hanya accessible oleh admin
    Route::resource('users', UserController::class);
});
```

---

### 5.3 Policies: UserPolicy & SuratKeluarPolicy
**Lokasi:** `app/Policies/UserPolicy.php`

```php
<?php
namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Hanya admin yang bisa view all users
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    // Hanya admin yang bisa view satu user
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    // Admin bisa delete user (tapi tidak diri sendiri)
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin() && $user->id !== $model->id;
    }
}
```

**Penggunaan di Controller:**
```php
public function destroy(User $user)
{
    $this->authorize('delete', $user);  // Policy check
    $user->delete();
}
```

---

### 5.4 User Roles
Sistem menggunakan 2 role:
1. **Admin** - Full access ke semua fitur
2. **Pegawai** - Hanya bisa create & view surat miliknya sendiri

---

## 6. 📚 Request Validation
**Lokasi:** `app/Http/Requests/`

- `StoreSuratKeluarRequest.php` - Validasi saat create surat
- `UpdateSuratKeluarRequest.php` - Validasi saat update surat

---

## 7. 🔗 DATABASE RELATIONSHIPS

```
Users (1) ──→ (Many) Surat Keluars
- User hasMany SuratKeluars
- SuratKeluar belongsTo User

Sessions (1) ──→ (Many) Users
- Untuk session management
```

---

## 8. 📌 FLOW DIAGRAM

```
User Access
    ↓
Check Authentication (Middleware: auth)
    ↓
Check Authorization:
    ├─ Admin Middleware: IsAdmin
    └─ Policies: UserPolicy, SuratKeluarPolicy
    ↓
Pass to Controller
    ↓
Controller Logic (use Model & Query)
    ↓
Return View or Redirect
```

---

## 9. 🔑 KEY FEATURES SUMMARY

| Fitur | Implementasi |
|-------|---|
| User Authentication | Session-based (Laravel Breeze) |
| User Registration | Public (dari auth.php) |
| Login/Logout | Session guard |
| Password Reset | Email-based token |
| Email Verification | Optional (commented out) |
| Role-Based Access | Admin vs Pegawai |
| Model Authorization | Policies (UserPolicy) |
| File Upload | SuratKeluar::file_surat |
| Search/Filter | Where clauses di Controller |
| Pagination | Built-in Laravel paginate() |
| Soft Delete | ❌ Not implemented |
| Audit Trail | ❌ Not implemented |

---

## 📝 CATATAN PENTING

1. **Authentication** menggunakan session (bukan token/API)
2. **Authorization** menggunakan middleware & policies
3. **Role** disimpan di users table sebagai enum (admin, pegawai)
4. **File Storage** di `storage/app/public/` 
5. **Database** menggunakan foreign keys dengan cascade delete
6. **Migrations** sudah di-track, support untuk rollback

---

*Laporan Backend Generated: 2026-04-24*
