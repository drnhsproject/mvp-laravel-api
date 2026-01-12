# API Authentication

This project uses Laravel Sanctum for API authentication. To interact with protected endpoints, you need to obtain a Bearer Token by using the login endpoint and include it in the `Authorization` header for subsequent requests.

## Endpoints

### 1. Register New User

Creates a new user account.

- **URL:** `/api/register`
- **Method:** `POST`
- **Headers:**
  - `Accept: application/json`
- **Body:**
  - `name` (string, required): The user's name.
  - `email` (string, required, unique): The user's email address.
  - `password` (string, required, min: 8): The user's password.
  - `password_confirmation` (string, required): Must match the password.

- **Success Response (201):**
  ```json
  {
    "message": "User registered successfully",
    "user": {
      "name": "Test User",
      "email": "test@example.com",
      "updated_at": "2026-01-12T05:30:00.000000Z",
      "created_at": "2026-01-12T05:30:00.000000Z",
      "id": 1
    }
  }
  ```

### 2. Login

Authenticates a user and returns a bearer token.

- **URL:** `/api/login`
- **Method:** `POST`
- **Headers:**
  - `Accept: application/json`
- **Body:**
  - `email` (string, required): The user's email address.
  - `password` (string, required): The user's password.

- **Success Response (200):**
  ```json
  {
    "access_token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "token_type": "Bearer"
  }
  ```

### 3. Get Authenticated User

Retrieves the details of the currently authenticated user.

- **URL:** `/api/user`
- **Method:** `GET`
- **Headers:**
  - `Accept: application/json`
  - `Authorization: Bearer <YOUR_ACCESS_TOKEN>`

- **Success Response (200):**
  ```json
  {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com",
    "email_verified_at": null,
    "created_at": "2026-01-12T05:30:00.000000Z",
    "updated_at": "2026-01-12T05:30:00.000000Z"
  }
  ```

### 4. Logout

Revokes the user's current access token.

- **URL:** `/api/logout`
- **Method:** `POST`
- **Headers:**
  - `Accept: application/json`
  - `Authorization: Bearer <YOUR_ACCESS_TOKEN>`

- **Success Response (200):**
  ```json
  {
    "message": "Successfully logged out"
  }
  ```
