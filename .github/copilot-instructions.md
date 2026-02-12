# Copilot Instructions for BlueOcean Web

This is a **Laravel 12** application with Tailwind CSS and Vite. Designed for a admin login interface built with modern Laravel features (Laravel 12+, PHP 8.2+).

## Project Architecture

### Core Stack
- **Backend**: Laravel 12 with PHP 8.2+ (Eloquent ORM, service container, middleware)
- **Frontend**: Vite + Tailwind CSS 4 (JSX/JS asset pipeline via `resources/`)
- **Database**: SQLite (default, MySQL available via config)
- **Testing**: PHPUnit with Laravel testing utilities (Feature/Unit test structure)
- **Asset Pipeline**: Vite with `laravel-vite-plugin` handling CSS/JS refresh during dev

### Key Entry Points
- Routes: `routes/web.php` — currently minimal (single auth login route)
- Views: `resources/views/` — Blade templates (login view at `admin/auth/login.blade.php`)
- Models: `app/Models/` — Eloquent models (User model with auth traits)
- Controllers: `app/Http/Controllers/` — (currently empty, add controllers here)

## Developer Workflows

### Initial Setup
```bash
composer run-script setup  # Install deps, generate key, run migrations, build assets
```

### Development
```bash
composer run dev  # Starts: Laravel server, queue listener, pail logs, Vite dev server (concurrently)
npm run dev       # Alternative: just Vite dev (file watching)
npm run build     # Production asset build
```

### Testing
```bash
composer test     # Clears config cache, runs PHPUnit (Unit + Feature suites)
php artisan test  # Run tests directly
```

### Database
```bash
php artisan migrate                  # Run pending migrations
php artisan migrate:rollback         # Rollback last batch
php artisan migrate:refresh --seed   # Fresh migration + run seeders
php artisan tinker                   # REPL for debugging models/queries
```

### Code Quality
- **Formatting**: Laravel Pint (`vendor/bin/pint`) — PSR-12 compliance
- **No linter enforced** — add via `composer require --dev laravel/pint` if needed

## Project Patterns & Conventions

### Database & Models
- **Migrations**: Located in `database/migrations/` — use `php artisan make:migration`
- **Factories**: `database/factories/` — use `HasFactory` trait for testing
- **Seeders**: `database/seeders/` — run via `migrate --seed`
- **Mass Assignment**: Use `$fillable` on models, never `$guarded = []` (see `app/Models/User.php`)

### Blade Views & Assets
- **Views**: `resources/views/` — use `.blade.php` extension
- **Blade Syntax**: `{{ }}` for escaping, `{!! !!}` for raw HTML, `@if`, `@foreach` directives
- **CSS/JS**: `resources/css/app.css` and `resources/js/app.js` — compiled by Vite
- **Tailwind**: Import in CSS or use `@apply` in Blade (Vite v4 supports JIT)
- **Asset imports in Blade**: Use `@vite()` to load versioned assets (Laravel Vite plugin handles this)

### Service Layer
- **Service Container**: Manage in `app/Providers/AppServiceProvider.php` — `register()` for bindings, `boot()` for initialization
- **Facades**: Available (Auth, Route, DB, etc.) — use sparingly, prefer dependency injection

### Authentication
- **Config**: `config/auth.php` — defaults to User model
- **Middleware**: Add to route groups in `routes/web.php`
- **Built-in traits**: User model includes `Authenticatable`, `Notifiable` (auth + notifications)

### Testing Conventions
- **Test location**: `tests/Feature/` and `tests/Unit/`
- **Base class**: Extend `Tests\TestCase` for feature tests (provides `$this->post()`, `$this->get()`, etc.)
- **DB state**: Tests use in-memory SQLite (`:memory:`) — no cleanup needed between tests
- **Factories**: Use `User::factory()->create()` to seed test data

## Critical Commands & Troubleshooting

### Common Issues
- **"Class not found"**: Run `composer autoload-dump`
- **Missing `.env`**: Copy `.env.example` → `.env`, run `php artisan key:generate`
- **Asset not updating**: Ensure Vite dev server is running (`npm run dev`), clear browser cache
- **Database locked**: Restart queue listener or PHP server if processes are hung

### Useful Artisan Commands
```bash
php artisan list                    # All available commands
php artisan make:controller Name    # Generate controller
php artisan make:model Name -m      # Model + migration
php artisan make:test Name          # Generate test
php artisan route:list              # View all routes
php artisan config:cache            # Cache config (production)
```

## Integration Points & External Dependencies

### Package Dependencies
- **laravel/framework ^12.0** — core framework
- **laravel/tinker** — REPL for debugging
- **tailwindcss ^4.0** — CSS framework
- **vite ^7.0** — asset bundler
- **axios ^1.11** — HTTP client (bundled, use in JS)

### Queue & Jobs
- Default driver: `sync` (testing) — change in `.env` for async processing
- Job location: `app/Jobs/` (not yet created)
- Queue config: `config/queue.php`

### No External APIs Configured
- Mail: Array driver (testing) — configure in `.env` for real emails
- Cache: Array driver (testing) — use Redis/Memcached in production
- Session: Array driver (testing) — use file/cookie in production

## File Naming & Path Conventions

```
app/                          # Application code
├── Http/Controllers/          # Request handlers
├── Models/                    # Eloquent models
├── Providers/                 # Service providers
├── Jobs/                      # Queued jobs (create as needed)
├── Mail/                      # Mailable classes
├── Events/                    # Dispatchable events
└── Exceptions/                # Custom exceptions

config/                       # Configuration files (loaded at runtime)
database/                     # Migrations, factories, seeders
resources/                    # Frontend assets
├── css/app.css               # Tailwind entry point
├── js/app.js                 # JavaScript entry point
└── views/                    # Blade templates
routes/                       # Route definitions
tests/                        # Test suites (Feature & Unit)
storage/                      # Cache, logs, uploads (git-ignored)
```

## Final Notes

- **Framework version**: Laravel 12 with latest PSR standards
- **PHP version**: 8.2+ (type hints, named args required)
- **Git workflow**: No `.git` info visible — follow standard feature branch conventions
- **Environment**: `.env` file controls all external service config (DB, mail, queue, etc.)
