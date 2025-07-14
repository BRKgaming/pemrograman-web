# Laravel Web Application - Tugas 3

## Deskripsi Proyek

Aplikasi web Laravel dengan fitur lengkap yang mencakup sistem autentikasi, dashboard, dan operasi CRUD. Aplikasi ini dibangun menggunakan Laravel 12 dengan desain yang responsif dan modern.

## Fitur Utama

### ✅ Authentication System
- **Login**: Halaman login dengan validasi email dan password
- **Register**: Halaman registrasi dengan validasi client-side dan server-side
- **Logout**: Sistem logout yang aman
- **Session Management**: Pengelolaan session yang secure

### ✅ Dashboard
- **Protected Route**: Dashboard hanya dapat diakses setelah login
- **User Statistics**: Menampilkan statistik pengguna
- **Welcome Message**: Pesan selamat datang yang personal
- **Quick Actions**: Aksi cepat untuk navigasi
- **Activity Timeline**: Riwayat aktivitas pengguna

### ✅ CRUD Operations
- **Create**: Membuat data baru
- **Read**: Menampilkan data
- **Update**: Mengubah data existing
- **Delete**: Menghapus data

### ✅ Database Integration
- **MySQL/SQLite**: Penyimpanan data menggunakan database
- **Migrations**: Struktur database yang terorganisir
- **Seeders**: Data dummy untuk testing

### ✅ Input Validation
- **Client-side**: Validasi JavaScript real-time
- **Server-side**: Validasi Laravel yang robust
- **Error Handling**: Penanganan error yang user-friendly

### ✅ Responsive Design
- **Mobile-first**: Desain yang mengutamakan mobile
- **Bootstrap 5**: Framework CSS yang modern
- **Cross-browser**: Kompatibel dengan berbagai browser

## Instalasi dan Penggunaan

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer

### Langkah Instalasi

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   # Untuk SQLite (default)
   touch database/database.sqlite
   ```

4. **Run Migrations dan Seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

### Default Login Credentials
- **Admin**: admin@example.com / password123
- **User**: john@example.com / password123

## Struktur Routes

### Public Routes
- `GET /` - Halaman utama
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `GET /register` - Halaman registrasi
- `POST /register` - Proses registrasi

### Protected Routes (Memerlukan Authentication)
- `GET /dashboard` - Dashboard pengguna
- `POST /logout` - Logout

## Teknologi yang Digunakan

### Backend
- **Laravel 12.x**: PHP Framework
- **PHP 8.2+**: Programming Language
- **SQLite**: Database (default)
- **Eloquent ORM**: Database management

### Frontend
- **HTML5**: Markup language
- **CSS3**: Styling dengan custom CSS
- **JavaScript**: Client-side interactivity
- **Bootstrap 5**: CSS Framework
- **Font Awesome**: Icon library

### Authentication
- **Laravel Built-in Auth**: Session-based authentication
- **Password Hashing**: Bcrypt untuk keamanan
- **CSRF Protection**: Token-based protection

## Fitur Keamanan

### Authentication
- ✅ CSRF Protection
- ✅ Password Hashing (Bcrypt)
- ✅ Session Management
- ✅ Remember Me functionality
- ✅ Input Sanitization

### Validation
- ✅ Server-side validation
- ✅ Client-side validation
- ✅ XSS Protection
- ✅ SQL Injection Protection

---

## About Laravel (Original Content)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
