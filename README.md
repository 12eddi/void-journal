# VOID — Journal Platform

A minimalist Laravel blog platform with Yeezy/DONDA-inspired aesthetics.

---

## Features

- **Articles** — Create, edit, read articles (admin can delete; users can create/edit own)
- **Polls** — Community voting system with live results
- **Auth** — Login, register with role-based access (admin / user)
- **Admin Panel** — Dashboard with stats, user management (promote/demote/delete)

## Roles & Permissions

| Action              | User | Admin |
|---------------------|------|-------|
| Read articles       | ✅   | ✅    |
| Create articles     | ✅   | ✅    |
| Edit own articles   | ✅   | ✅    |
| Edit any article    | ❌   | ✅    |
| Delete articles     | ❌   | ✅    |
| Vote on polls       | ✅   | ✅    |
| Create polls        | ✅   | ✅    |
| Delete polls        | ❌   | ✅    |
| Admin panel         | ❌   | ✅    |
| Manage users        | ❌   | ✅    |

---

## Setup

### Requirements
- PHP 8.2+
- Composer
- SQLite (or MySQL/PostgreSQL)

### Installation

```bash
# 1. Clone / unzip the project
cd yeezy-blog

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (SQLite — simplest)
touch database/database.sqlite
# In .env set:
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite

# 5. Run migrations + seed
php artisan migrate --seed

# 6. Start development server
php artisan serve
```

### Default Accounts (after seeding)

| Email            | Password | Role  |
|------------------|----------|-------|
| admin@void.com   | password | admin |
| user@void.com    | password | user  |

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      — Login, Register, Logout
│   │   ├── ArticleController.php   — CRUD articles
│   │   ├── PollController.php      — CRUD polls + voting
│   │   └── AdminController.php     — Admin dashboard + user mgmt
│   └── Middleware/
│       └── AdminMiddleware.php     — Protects admin routes
├── Models/
│   ├── User.php
│   ├── Article.php
│   ├── Poll.php
│   ├── PollOption.php
│   └── PollVote.php
database/
├── migrations/                     — DB schema
└── seeders/DatabaseSeeder.php      — Sample data
resources/views/
├── layouts/app.blade.php           — Main layout (Yeezy design)
├── auth/                           — Login, Register
├── articles/                       — Index, Show, Create, Edit
├── polls/                          — Index, Show, Create
└── admin/                          — Dashboard, Users
routes/web.php                      — All routes
```

---

## Design System

Built on a raw, monochromatic palette inspired by Yeezy/DONDA aesthetics:

- **Background**: `#0a0a0a` — near-black
- **Surface**: `#111111` — card backgrounds
- **Accent**: `#c8b89a` — warm sand/bone
- **Text**: `#e8e4df` — soft white
- **Typography**: Bebas Neue (display) + DM Mono (labels) + Hanken Grotesk (body)

---

## Key Routes

```
GET  /                    Articles homepage
GET  /articles            Article list
GET  /articles/{slug}     Article detail
GET  /articles/create     Create form (auth)
POST /articles            Store article (auth)

GET  /polls               Poll list
GET  /polls/{id}          Poll detail + vote
GET  /polls/create        Create form (auth)
POST /polls/{id}/vote     Cast vote (auth)

GET  /admin               Admin dashboard
GET  /admin/users         User management

GET  /login               Login form
POST /login               Authenticate
GET  /register            Register form
POST /register            Create account
POST /logout              Sign out
```
