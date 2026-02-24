# Narasi - Content Management System

A modern, full-featured Content Management System (CMS) built with Laravel 12, Livewire 4, and Flux UI. Narasi provides a robust platform for creating, managing, and publishing articles with a clean and intuitive interface.

## Features

### User Management

- **Multi-Role System**: Three user roles - Admin, Writer, and User
- **Authentication**: Secure authentication with Laravel Fortify
- **Two-Factor Authentication**: Optional 2FA for enhanced security
- **Email Verification**: Built-in email verification system

### Article Management

- **Status Workflow**: Draft → Pending → Published
- **Rich Content**: Full article management with title, excerpt, content, and thumbnail
- **Slug Generation**: Automatic URL-friendly slug creation
- **Publishing Control**: Schedule and manage publication dates
- **Author Attribution**: Each article links to its author

### Category System

- **Category Management**: Create and manage article categories
- **Organization**: Organize content by category
- **Slug-based URLs**: SEO-friendly category links

### Admin Dashboard

- **Article Verification**: Review and approve pending articles
- **Category Management**: Full CRUD operations for categories
- **User Management**: Manage user roles and accounts
- **Overview Dashboard**: Quick stats and overview

### Writer Features

- **Personal Dashboard**: Dedicated area for writers
- **Article Management**: Create, edit, and manage own articles
- **Status Tracking**: Monitor article status (draft/pending/published)

### Public Interface

- **Home Page**: Browse published articles
- **Article Detail**: Read full articles with clean typography
- **Category Filtering**: View articles by category

## Tech Stack

- **Framework**: Laravel 12
- **Frontend**: Livewire 4
- **UI Components**: Livewire Flux
- **Authentication**: Laravel Fortify
- **Database**: MySQL/SQLite
- **PHP**: 8.2+

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL or SQLite database

### Setup Steps

1. **Clone the Repository**

```
bash
git clone https://github.com/jodijonatan/narasi.git
cd narasi
```

2. **Install PHP Dependencies**

```
bash
composer install
```

3. **Environment Configuration**

```
bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database**

For MySQL, update `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=narasi
DB_USERNAME=root
DB_PASSWORD=
```

Or for SQLite:

```
DB_CONNECTION=sqlite
touch database/database.sqlite
```

5. **Run Migrations**

```
bash
php artisan migrate
```

6. **Seed Database**

```
bash
php artisan db:seed
```

7. **Install Frontend Dependencies**

```
bash
npm install
npm run build
```

### Running the Application

**Development Server**

```
bash
php artisan serve
```

**With Queue and Vite (Full Development)**

```
bash
npm run dev
```

Visit `http://localhost:8000` to access the application.

## Default Credentials

After seeding, you can login with these default accounts:

| Role   | Email              | Password |
| ------ | ------------------ | -------- |
| Admin  | admin@narasi.test  | password |
| Writer | writer@narasi.test | password |
| User   | user@narasi.test   | password |

## Project Structure

```
narasi/
├── app/
│   ├── Actions/           # Laravel Actions
│   ├── Concerns/          # Shared concerns/traits
│   ├── Http/
│   │   ├── Controllers/   # HTTP Controllers
│   │   └── Middleware/    # Route Middleware
│   ├── Livewire/
│   │   ├── Admin/         # Admin components
│   │   ├── Public/        # Public-facing components
│   │   └── Writer/        # Writer dashboard components
│   ├── Models/            # Eloquent Models
│   └── Providers/         # Service Providers
├── database/
│   ├── factories/         # Database factories
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── resources/
│   └── views/
│       ├── admin/         # Admin views
│       ├── articles/      # Public article views
│       ├── components/   # Blade components
│       └── layouts/       # Layout files
├── routes/
│   ├── web.php           # Web routes
│   └── settings.php      # Settings routes
└── tests/                # Test files
```

## Routes

### Public Routes

- `/` - Home page (article listing)
- `/articles/{slug}` - Article detail page
- `/login` - User login
- `/register` - User registration

### Authenticated Routes

- `/dashboard` - User dashboard
- `/my-articles` - Writer article management

### Admin Routes (Admin Only)

- `/admin/dashboard` - Admin dashboard
- `/admin/verify` - Article verification
- `/admin/categories` - Category management
- `/admin/users` - User management

## Available Commands

```
bash
# Clear configuration cache
php artisan config:clear

# Run tests
php artisan test

# Lint code
composer lint

# Build frontend assets
npm run build
```

## Security

- Passwords are hashed using Laravel's bcrypt
- Two-factor authentication support via Laravel Fortify
- Role-based access control (RBAC)
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues and feature requests, please create an issue in the project repository.
