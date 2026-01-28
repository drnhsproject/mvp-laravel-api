# MVP Backend API

## Authentication & Authorization

This project implements a robust JWT-based authentication system using Laravel Sanctum with custom enhancements for Refresh Token flow and Role-Based Access Control (RBAC).

### Features

- **Dual Token System**: Short-lived Access Tokens (default 60m) and Long-lived Refresh Tokens (default 2 weeks) with rotation.
- **RBAC**: Multi-role support with additive permissions.
- **Account Security**: Login throttling and temporary account lockout after failed attempts.
- **Optimized Responses**: Lightweight, frontend-ready JSON structures.

### Environment Configuration

Configure the token lifetimes and CORS settings in your `.env` file:

```dotenv
# Token Lifetimes (in minutes)
AUTH_ACCESS_TOKEN_TTL=60
AUTH_REFRESH_TOKEN_TTL=20160

# CORS (Default allows all *)
SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

### API Endpoints

#### `POST /api/login`

Authenticates a user and returns an access token pairing.
**Payload:** `{ "login": "email_or_username", "password": "..." }`
**Response:**

```json
{
  "user": { "id": 1, "roles": [...] },
  "permissions": [ { "module": "users", "action": "create" } ],
  "access_token": "...",
  "refresh_token": "...",
  "expires_in": 3600
}
```

#### `POST /api/refresh`

Exchanges a valid refresh token for a new access/refresh pair. Old refresh token is revoked (rotation).
**Payload:** `{ "refresh_token": "..." }`
**Response:** New token pair.

#### `GET /api/me`

Retrieves current user profile and calculated permissions.
**Headers:** `Authorization: Bearer <access_token>`

## Seeders

Run `php artisan db:seed` to populate:

- **Super Admin**: `superadmin@app.com` / `Admin@321`
- **System**: `system@app.com` / `Admin@321`
- Roles: `Super Admin`
- Privileges: `*.*` (All Access)

## CORS

CORS is valid and enabled by default for `api/*` paths from any origin (`*`). This is ready for Frontend integration.
