# Technical Documentation - HWA Program

## Table of Contents

1. [Overview](#overview)
2. [Technology Stack](#technology-stack)
3. [System Architecture](#system-architecture)
4. [Database Structure](#database-structure)
5. [Authentication & Authorization](#authentication--authorization)
6. [Project Structure](#project-structure)
7. [Key Components](#key-components)
8. [Installation & Setup](#installation--setup)
9. [Deployment](#deployment)
10. [API Endpoints](#api-endpoints)
11. [Performance & Optimization](#performance--optimization)
12. [Security Considerations](#security-considerations)
13. [Troubleshooting](#troubleshooting)

---

## Overview

**HWA Program** is a web-based industrial operations management system built with Laravel. The application manages various manufacturing processes including welding, rolling, cutting, folding, perforation, and materials management.

### Key Features
- Multi-guard authentication (User & Admin)
- Order management with automatic pricing calculation
- Shopping cart functionality
- Invoice generation and printing
- Admin dashboard with statistics
- RTL (Right-to-Left) Arabic interface

---

## Technology Stack

### Backend
- **PHP**: 8.0.2+
- **Framework**: Laravel 9.x
- **Database**: MySQL 5.7+
- **ORM**: Eloquent
- **Template Engine**: Blade

### Frontend
- **UI Framework**: Bootstrap 5
- **JavaScript**: Vanilla JS + Fetch API
- **Icons**: Tabler Icons
- **Charts**: ApexCharts
- **Notifications**: SweetAlert2
- **Animations**: Animate.css

### Development Tools
- **Dependency Manager**: Composer
- **Package Manager**: npm
- **Version Control**: Git

### Key Laravel Packages
```json
{
    "laravel/framework": "^9.19",
    "laravel/sanctum": "^3.0",
    "laravel/tinker": "^2.7",
    "realrashid/sweet-alert": "^5.1",
    "guzzlehttp/guzzle": "^7.2"
}
```

---

## System Architecture

### High-Level Architecture

```
┌─────────────┐
│   Browser   │
│  (User/     │
│   Admin)    │
└──────┬──────┘
       │ HTTP/HTTPS
       ↓
┌─────────────────────────────┐
│   Laravel Application       │
│                             │
│  ┌─────────────────────┐   │
│  │   Routes Layer      │   │
│  │  - web.php          │   │
│  │  - Admin.php        │   │
│  └──────────┬──────────┘   │
│             ↓              │
│  ┌─────────────────────┐   │
│  │  Middleware Layer   │   │
│  │  - auth             │   │
│  │  - AdminAuth        │   │
│  └──────────┬──────────┘   │
│             ↓              │
│  ┌─────────────────────┐   │
│  │ Controllers Layer   │   │
│  │  - User/*           │   │
│  │  - Admin/*          │   │
│  └──────────┬──────────┘   │
│             ↓              │
│  ┌─────────────────────┐   │
│  │   Models Layer      │   │
│  │  - Eloquent ORM     │   │
│  └──────────┬──────────┘   │
│             ↓              │
│  ┌─────────────────────┐   │
│  │   Views Layer       │   │
│  │  - Blade Templates  │   │
│  └─────────────────────┘   │
└─────────────┬───────────────┘
              ↓
       ┌──────────────┐
       │    MySQL     │
       │   Database   │
       └──────────────┘
```

### Request Flow

```
User Request
    ↓
Routes (web.php / Admin.php)
    ↓
Middleware (auth / AdminAuth)
    ↓
Controller
    ↓
Model (Eloquent)
    ↓
Database
    ↓
View (Blade)
    ↓
Response
```

---

## Database Structure

### Core Tables

#### 1. `users`
Stores regular user accounts.
```sql
- id (PK)
- name
- email
- password
- created_at
- updated_at
```

#### 2. `admins`
Stores admin accounts (separate from users).
```sql
- id (PK)
- name
- email
- password
- created_at
- updated_at
```

#### 3. `orders`
Main orders table.
```sql
- id (PK, AUTO_INCREMENT)
- user_id (FK → users.id)
- status ENUM('unpaid', 'paied')
- quantity (total items in order)
- paid_at (timestamp)
- created_at
- updated_at
```

#### 4. `orderdetailes`
Order line items (individual operations).
```sql
- id (PK)
- order_id (FK → orders.id)
- operation_type (welding, cutting, folding, etc.)
- length
- width
- thickness
- quantity
- price
- weight
- created_at
- updated_at
```

#### 5. `foldprices`
Pricing table for folding operations based on thickness.
```sql
- id (PK)
- value (thickness value: 1-10)
- price (price per unit)
- created_at
- updated_at
```

#### 6. `fold_length_prices`
Additional pricing for folding based on length.
```sql
- id (PK)
- length_range
- price
- created_at
- updated_at
```

### Database Relationships

```
users (1) ──── (N) orders
orders (1) ──── (N) orderdetailes
foldprices (1) ──── (N) orderdetailes (for folding operations)
```

### Important Notes
- **Foreign Key Constraints**: `orderdetailes.order_id` references `orders.id` with `ON DELETE CASCADE`
- **Order Status**: Only `paied` orders are counted in admin statistics
- **Auto-increment Reset**: Can be reset via admin command (development only)

---

## Authentication & Authorization

### Multi-Guard System

The application uses **two separate authentication guards**:

#### 1. Web Guard (Default - Users)
```php
// config/auth.php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
]
```

**Login Route**: `/user/login`  
**Middleware**: `auth`  
**Access**: Regular users (create orders, manage their own data)

#### 2. Admin Guard
```php
// config/auth.php
'guards' => [
    'Admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
]
```

**Login Route**: `/Admin/login`  
**Middleware**: `AdminAuth`  
**Access**: Administrators (view all orders, statistics, system management)

### Middleware

#### `auth` (User Authentication)
```php
// app/Http/Middleware/Authenticate.php
protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('login');
    }
}
```

#### `AdminAuth` (Admin Authentication)
```php
// app/Http/Middleware/AdminAuth.php
public function handle(Request $request, Closure $next)
{
    if(!Auth::guard('Admin')->check()){
        return redirect()->route('adminLogin');
    }
    return $next($request);
}
```

### Checking Authentication in Blade

**For Users:**
```blade
@auth
    {{ auth()->user()->name }}
@endauth
```

**For Admins:**
```blade
@if(\Illuminate\Support\Facades\Auth::guard('Admin')->check())
    {{ \Illuminate\Support\Facades\Auth::guard('Admin')->user()->name }}
@endif
```

### Special Admin Permissions

The `cost.accounting` admin has special permissions:
- Reset order numbers (development feature)
- This is checked in routes and views:

```php
$adminName = strtolower(trim(Auth::guard('Admin')->user()->name ?? ''));
if ($adminName === 'cost.accounting' || $adminName === 'cost accounting') {
    // Allow special operations
}
```

---

## Project Structure

```
HwaProgram/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── ResetOrderNumbers.php     # Artisan command for dev
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── Auth/
│   │   │   │   │   └── AuthController.php
│   │   │   │   ├── dashboardController.php
│   │   │   │   ├── foldcontroller.php
│   │   │   │   └── [other controllers]
│   │   │   └── User/
│   │   │       ├── Auth/
│   │   │       │   └── AuthController.php
│   │   │       ├── Cart/
│   │   │       │   └── CartController.php
│   │   │       ├── foldcontroller.php
│   │   │       └── [other controllers]
│   │   └── Middleware/
│   │       ├── AdminAuth.php
│   │       └── Authenticate.php
│   └── Models/
│       ├── User.php
│       ├── Admin.php
│       ├── Order.php
│       ├── Orderdetailes.php
│       ├── Foldprice.php
│       └── fold_length_price.php
│
├── config/
│   └── auth.php                          # Authentication configuration
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/
│   │   └── plugins/
│   │       ├── sweet-alert2/
│   │       ├── apexcharts/
│   │       └── animate/
│   └── index.php
│
├── resources/
│   └── views/
│       ├── Admin/
│       │   ├── dashboard/
│       │   │   └── index.blade.php
│       │   └── [other admin views]
│       ├── User/
│       │   ├── home/
│       │   │   └── index.blade.php
│       │   ├── cart/
│       │   │   ├── index.blade.php
│       │   │   ├── checkout.blade.php
│       │   │   └── print.blade.php
│       │   └── follding/
│       │       └── folldingboard.blade.php
│       ├── layout/                       # Admin layouts
│       │   ├── head.blade.php
│       │   ├── footer.blade.php
│       │   └── sidebar.blade.php
│       └── userlayout/                   # User layouts
│           ├── head.blade.php
│           ├── footer.blade.php
│           └── sidebar.blade.php
│
├── routes/
│   ├── web.php                          # User routes
│   ├── Admin.php                        # Admin routes
│   └── api.php
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── .env                                 # Environment configuration
├── composer.json
├── artisan
└── README.md
```

---

## Key Components

### 1. Controllers

#### User Controllers

**foldcontroller.php** (User)
```php
namespace App\Http\Controllers\User;

class foldcontroller extends Controller
{
    public function foldingboardorder(Request $request)
    {
        // Validate input
        $request->validate([
            'length' => 'required',
            'width' => 'required',
            'thickness' => 'required',
        ]);
        
        $thickness = $request->thickness;
        $weight = $this->weight(...);
        
        // Price calculation based on thickness
        if($thickness < 1){
            // Use price for 1mm
            $price = Foldprice::where('value', 1)->first();
        }
        elseif($thickness >= 1 && $thickness <= 9){
            $price = Foldprice::where('value', round($thickness))->first();
        }
        elseif($thickness == 10 || $thickness == 11 || $thickness == 12){
            $price = Foldprice::where('value', 10)->first();
        }
        
        // Add to order...
    }
}
```

**CartController.php**
```php
namespace App\Http\Controllers\User\Cart;

class CartController extends Controller
{
    public function index()
    {
        // Get unpaid order for current user
        $order = Order::with('orderdetailes')
                      ->where('user_id', Auth::user()->id)
                      ->where('status', 'unpaid')
                      ->first();
        
        return view('User.cart.index', compact('order'));
    }
    
    public function paied(Request $request)
    {
        // Mark order as paid
        $order = Order::find($request->order_id);
        $order->update([
            'status' => 'paied',
            'paid_at' => now()
        ]);
        
        return redirect()->route('user.cart.print', $order->id);
    }
}
```

#### Admin Controllers

**dashboardController.php**
```php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

class dashboardController extends Controller
{
    public function index()
    {
        // Count only PAID orders
        $totalOrdersCount = Order::where('status', 'paied')->count() ?? 0;
        
        $todayOrdersCount = Order::where('status', 'paied')
                                  ->whereDate('paid_at', Carbon::today())
                                  ->count() ?? 0;
        
        // Revenue calculations...
        
        return view('Admin.dashboard.index', compact(
            'totalOrdersCount',
            'todayOrdersCount',
            // ... other data
        ));
    }
}
```

### 2. Models

**Order.php**
```php
namespace App\Models;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'quantity',
        'paid_at'
    ];
    
    public function orderdetailes()
    {
        return $this->hasMany(Orderdetailes::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

**Foldprice.php**
```php
namespace App\Models;

class Foldprice extends Model
{
    protected $fillable = ['value', 'price'];
}
```

### 3. Views

**Blade Layout Structure**

Admin views extend:
```blade
@extends('layout.main')
@section('content')
    <!-- Content here -->
@endsection
@section('scripts')
    <!-- Scripts here -->
@endsection
```

User views extend:
```blade
@extends('userlayout.main')
@section('content')
    <!-- Content here -->
@endsection
```

**SweetAlert2 Integration**

Correct loading order in `resources/views/layout/footer.blade.php`:
```blade
<!-- Load SweetAlert2 -->
<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Then load page scripts -->
@yield('scripts')

<!-- Finally other plugins -->
<script src="{{asset('assets/js/app.js')}}"></script>
```

CSS in `resources/views/layout/head.blade.php`:
```blade
<link href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/animate/animate.min.css')}}" rel="stylesheet">
```

---

## Installation & Setup

### Prerequisites
- PHP >= 8.0.2
- Composer
- MySQL 5.7+
- Apache/Nginx
- Node.js & npm (optional, for asset compilation)

### Step 1: Clone Repository
```bash
git clone <repository-url>
cd HwaProgram
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hwa_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
php artisan migrate
```

### Step 6: Create Storage Link
```bash
php artisan storage:link
```

### Step 7: Seed Database (Optional)
```bash
php artisan db:seed
```

### Step 8: Set Permissions
```bash
# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Or using chown
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### Step 9: Run Development Server
```bash
php artisan serve
```

Access the application:
- **User Login**: http://localhost:8000/user/login
- **Admin Login**: http://localhost:8000/Admin/login

---

## Deployment

### Production Checklist

#### 1. Environment Setup
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

#### 2. Optimize Application
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

#### 3. Security
- Set strong `APP_KEY`
- Use HTTPS
- Configure CORS properly
- Set secure session settings
- Enable CSRF protection (enabled by default)

#### 4. Database
- Use production database credentials
- Regular backups
- Optimize queries and indexes

#### 5. Server Configuration

**Apache (.htaccess)**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/HwaProgram/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Deployment to Shared Hosting (Hostinger, etc.)

1. **Upload Files**
   - Upload all files to public_html or appropriate directory
   - Move `public` folder contents to root if needed

2. **Update Paths**
   - Update `index.php` to adjust paths if structure changed

3. **Database**
   - Create MySQL database via cPanel
   - Update `.env` with database credentials
   - Import database or run migrations

4. **Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

5. **Clear Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

---

## API Endpoints

### User Routes (`routes/web.php`)

| Method | URI | Name | Controller | Middleware |
|--------|-----|------|------------|------------|
| GET | `/user/login` | `login` | `AuthController@login` | - |
| POST | `/user/login` | `user.login` | `AuthController@Submitlogin` | - |
| GET | `/logout` | `logout` | `AuthController@logout` | - |
| GET | `/user/home` | `user.home` | `HomeController@index` | `auth` |
| GET | `/user/folding/boards` | `user.folding.boards` | `foldcontroller@foldingboard` | `auth` |
| POST | `/user/folding/boards` | `folding.board.order` | `foldcontroller@foldingboardorder` | `auth` |
| GET | `/user/cart` | `user.cart` | `CartController@index` | `auth` |
| POST | `/user/paied` | `user.paied` | `CartController@paied` | `auth` |
| GET | `/user/cart/print/{id}` | `user.cart.print` | `CartController@print` | `auth` |

### Admin Routes (`routes/Admin.php`)

| Method | URI | Name | Controller | Middleware |
|--------|-----|------|------------|------------|
| GET | `/Admin/login` | `adminLogin` | `AuthController@login` | - |
| POST | `/Admin/login` | `Admin.login` | `AuthController@Submitlogin` | - |
| GET | `/Admin/logout` | `Admin.logout` | `AuthController@logout` | - |
| GET | `/Admin/dashboard` | `Admin.dashboard` | `dashboardController@index` | `AdminAuth` |
| POST | `/Admin/reset-order-numbers` | `admin.reset-order-numbers` | `Closure` | `AdminAuth` |

### AJAX Endpoints

**Reset Order Numbers** (Admin only, cost.accounting)
```javascript
fetch('/Admin/reset-order-numbers', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token,
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(response => response.json())
.then(data => {
    // Handle response
});
```

Response:
```json
{
    "success": true,
    "message": "تم إعادة تعيين أرقام الطلبات بنجاح!"
}
```

---

## Performance & Optimization

### Database Optimization

1. **Indexes**
   - Add indexes on frequently queried columns:
     - `orders.user_id`
     - `orders.status`
     - `orders.paid_at`
     - `orderdetailes.order_id`

2. **Query Optimization**
   - Use eager loading to prevent N+1 queries:
   ```php
   $order = Order::with('orderdetailes')->find($id);
   ```

3. **Pagination**
   - Implement pagination for large datasets:
   ```php
   $orders = Order::where('status', 'paied')->paginate(20);
   ```

### Caching

1. **Configuration Cache**
   ```bash
   php artisan config:cache
   ```

2. **Route Cache**
   ```bash
   php artisan route:cache
   ```

3. **View Cache**
   ```bash
   php artisan view:cache
   ```

4. **Query Caching** (if needed)
   ```php
   $stats = Cache::remember('dashboard_stats', 3600, function () {
       return Order::where('status', 'paied')->count();
   });
   ```

### Frontend Optimization

1. **Asset Minification**
   - Minify CSS and JavaScript files
   - Use Laravel Mix if needed

2. **Image Optimization**
   - Compress images
   - Use appropriate formats (WebP where possible)

3. **Lazy Loading**
   - Implement lazy loading for charts and heavy components

---

## Security Considerations

### 1. CSRF Protection
Laravel's CSRF protection is enabled by default. Always include CSRF token in forms and AJAX requests:

```blade
@csrf
```

```javascript
'X-CSRF-TOKEN': '{{ csrf_token() }}'
```

### 2. SQL Injection Prevention
Always use Eloquent or Query Builder with parameter binding:
```php
// Good
Order::where('user_id', $userId)->get();

// Bad
DB::select("SELECT * FROM orders WHERE user_id = $userId");
```

### 3. XSS Prevention
Blade's `{{ }}` syntax escapes output automatically:
```blade
{{ $user->name }} <!-- Safe -->
{!! $user->name !!} <!-- Unsafe, use only for trusted HTML -->
```

### 4. Mass Assignment Protection
Define `$fillable` or `$guarded` in models:
```php
protected $fillable = ['name', 'email', 'status'];
```

### 5. Authentication
- Use strong password hashing (bcrypt, default in Laravel)
- Implement rate limiting on login routes
- Session timeout configuration

### 6. Sensitive Operations
The reset order numbers feature should:
- **Never be used in production**
- Only accessible to specific admin
- Require confirmation
- Be logged

### 7. Environment Variables
Never commit `.env` file. Keep sensitive data in environment variables:
- Database credentials
- API keys
- APP_KEY

---

## Troubleshooting

### Common Issues

#### 1. SweetAlert2 Not Displaying Properly

**Symptom**: Empty dialog or text not showing

**Solution**:
1. Check script loading order in footer:
```blade
<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
@yield('scripts')
```

2. Ensure CSS is loaded:
```blade
<link href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/animate/animate.min.css')}}" rel="stylesheet">
```

3. Remove duplicate SweetAlert CDN includes

#### 2. Foreign Key Constraint Error on Reset

**Error**: `Cannot truncate a table referenced in a foreign key constraint`

**Solution**: Use `DELETE` instead of `TRUNCATE` with foreign key checks disabled:
```php
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
DB::table('orderdetailes')->delete();
DB::table('orders')->delete();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
```

#### 3. Orders Not Showing in Admin Dashboard

**Cause**: Dashboard only shows paid orders

**Solution**: Ensure order status is `paied` (note the spelling):
```php
$order->update(['status' => 'paied', 'paid_at' => now()]);
```

#### 4. Thickness Less Than 1mm Not Accepted

**Cause**: Old validation logic

**Solution**: Updated in `foldcontroller.php`:
```php
if($thickness < 1){
    $price = Foldprice::where('value', 1)->first();
    // ... rest of logic
}
```

#### 5. Permission Denied Errors

**Linux/Mac**:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Windows**: Ensure IIS/Apache user has write permissions

#### 6. 500 Internal Server Error

**Debug Steps**:
1. Enable debug mode temporarily:
```env
APP_DEBUG=true
```

2. Check Laravel logs:
```bash
tail -f storage/logs/laravel.log
```

3. Check web server logs (Apache/Nginx)

4. Clear all caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 7. Database Connection Issues

**Check**:
1. Database credentials in `.env`
2. MySQL service is running
3. Host is correct (localhost vs 127.0.0.1)
4. Port is correct (usually 3306)
5. Database exists
6. User has proper permissions

#### 8. Assets Not Loading

**Solutions**:
1. Run `php artisan storage:link`
2. Check asset paths in blade files
3. Verify `APP_URL` in `.env`
4. Clear browser cache
5. Check file permissions

---

## Development Commands

### Artisan Commands

```bash
# View all routes
php artisan route:list

# View all routes for specific guard
php artisan route:list --name=Admin

# Create new controller
php artisan make:controller User/NewController

# Create new model with migration
php artisan make:model ModelName -m

# Create new middleware
php artisan make:middleware MiddlewareName

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset database (careful!)
php artisan migrate:fresh

# Clear caches
php artisan optimize:clear

# View application info
php artisan about
```

### Custom Artisan Command

**Reset Order Numbers** (Development only):
```bash
php artisan orders:reset-numbers --delete
```

Location: `app/Console/Commands/ResetOrderNumbers.php`

---

## Maintenance

### Regular Tasks

1. **Database Backups**
   - Daily automated backups
   - Store in secure location
   - Test restore procedures

2. **Log Monitoring**
   - Check `storage/logs/laravel.log`
   - Monitor for errors and warnings
   - Set up log rotation

3. **Security Updates**
   - Keep Laravel updated
   - Update dependencies: `composer update`
   - Check for security advisories

4. **Performance Monitoring**
   - Monitor query performance
   - Check server resources
   - Optimize slow queries

5. **Cleanup**
   - Archive old orders
   - Clean up temporary files
   - Optimize database tables

---

## Contact & Support

For technical support or questions about this documentation, contact the development team.

---

**Last Updated**: January 2025  
**Laravel Version**: 9.x  
**PHP Version**: 8.0.2+

