# Islamic Learning Backend

Laravel 11 API and Filament 3 admin panel for the Islamic Learning mobile app. Admins manage ustazes, topics, derses (lessons), and episodes; the Flutter app consumes a public read-only API.

## Requirements

- PHP 8.2+
- Composer
- SQLite (default) or MySQL
- Node.js (optional, only if you customize Filament/Vite assets)

## Setup

1. **Install dependencies**

   ```bash
   composer install
   ```

2. **Environment file**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database**

   SQLite (default):

   ```bash
   touch database/database.sqlite
   ```

   MySQL (optional): set `DB_CONNECTION=mysql` and the `DB_*` variables in `.env`, then create the database.

4. **Migrate and seed**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage link** (required for PDF/audio uploads and public API file URLs)

   ```bash
   php artisan storage:link
   ```

6. **Run the server**

   ```bash
   php artisan serve
   ```

   - Admin panel: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
   - API base: `http://127.0.0.1:8000/api/v1`

## Environment variables

| Variable | Description | Example |
|---|---|---|
| `APP_URL` | Base URL of the backend (used for storage URLs) | `http://127.0.0.1:8000` |
| `DB_CONNECTION` | Database driver | `sqlite` or `mysql` |
| `DB_DATABASE` | SQLite path or MySQL database name | `database/database.sqlite` |
| `FILESYSTEM_DISK` | Default upload disk | `public` |
| `ADMIN_EMAIL` | Filament admin login email | `admin@example.com` |
| `ADMIN_PASSWORD` | Filament admin login password | `password` |
| `ADMIN_NAME` | Display name for the seeded admin | `Admin` |
| `CORS_ALLOWED_ORIGINS` | Comma-separated browser origins allowed to call `/api/*` | `*` (local dev) |

## Admin panel

Log in at `/admin` with the credentials from `ADMIN_EMAIL` and `ADMIN_PASSWORD`.

Use the Filament dashboard to manage:

- Ustazes and topics
- Derses (PDF upload, cover image, ustaz/topic assignment)
- Episodes (audio upload, start page) — nested under each Ders or via the Episodes resource

## Public API

Read-only, unauthenticated endpoints:

| Method | Path | Description |
|---|---|---|
| GET | `/api/v1/content` | Full bundle (ustazes, topics, derses with episodes) |
| GET | `/api/v1/ustazes` | Active ustazes |
| GET | `/api/v1/topics` | Active topics |
| GET | `/api/v1/derses` | Published derses (`?ustaz_id=`, `?topic_id=`) |
| GET | `/api/v1/derses/{id}` | Single ders with published episodes |

Only `is_active` ustazes/topics and `is_published` derses/episodes are returned. File fields are full public storage URLs.

## CORS (Flutter app)

CORS is configured in `config/cors.php` for all routes under `api/*` (including `/api/v1/*`).

- **Flutter mobile (iOS/Android):** CORS does not apply; point the app at `APP_URL`.
- **Flutter web / browser testing:** set `CORS_ALLOWED_ORIGINS` in `.env`. Use `*` for local development, or restrict to your web origin in production, for example:

  ```env
  CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:3000
  ```

Allowed methods for the public API: `GET`, `HEAD`, `OPTIONS`.

## Tests

```bash
php artisan test
```

## File upload limits

- PDF (ders): 50 MB max
- Audio (episode): 30 MB max

Deleting a Ders or Episode removes its files from storage automatically.
