# SysParams Module Documentation

## Overview

The **SysParams** module manages system parameters (configuration settings) for the application. It follows **Domain-Driven Design (DDD)** and **Clean Architecture** principles as defined in `AGENTS.md`.

## Database Schema

### Table: `system_parameters`

| Column      | Type      | Nullable | Description                   |
| ----------- | --------- | -------- | ----------------------------- |
| id          | bigint    | No       | Primary key                   |
| code        | uuid      | No       | Unique UUID v7 identifier     |
| groups      | string    | No       | Parameter group/category      |
| key         | string    | No       | Parameter key                 |
| value       | text      | No       | Parameter value               |
| ordering    | integer   | Yes      | Display/sort order            |
| description | text      | Yes      | Parameter description         |
| status      | integer   | No       | Status (1=active, 0=inactive) |
| created_by  | bigint    | Yes      | Foreign key to users          |
| updated_by  | bigint    | Yes      | Foreign key to users          |
| created_at  | timestamp | No       | Creation timestamp            |
| updated_at  | timestamp | No       | Last update timestamp         |
| deleted_at  | timestamp | Yes      | Soft delete timestamp         |

**Indexes:**

- Composite index on `(groups, key)` for faster queries

## Module Structure

```
app/Modules/SysParams/
├── Domain/
│   └── Contracts/
│       └── SystemParameterRepositoryInterface.php
├── Application/
│   ├── Commands/
│   │   ├── CreateSystemParameterCommand.php
│   │   └── UpdateSystemParameterCommand.php
│   ├── DTOs/
│   │   └── GetSystemParameterListQuery.php
│   └── UseCases/
│       ├── CreateSystemParameter.php
│       ├── DeleteSystemParameter.php
│       ├── GetSystemParameter.php
│       ├── GetSystemParameterList.php
│       └── UpdateSystemParameter.php
├── Infrastructure/
│   └── Persistence/
│       └── Repositories/
│           └── PostgresSystemParameterRepository.php
└── Presentation/
    ├── Controllers/
    │   └── SystemParameterController.php
    ├── Requests/
    │   ├── StoreSystemParameterRequest.php
    │   └── UpdateSystemParameterRequest.php
    └── Resources/
        └── SystemParameterResource.php
```

## API Endpoints

All endpoints require authentication (`auth:sanctum`) and permission checking (`check.permission`).

### List System Parameters

```
GET /api/sysparams
Route Name: sysparam.list
```

**Query Parameters:**

- `search` (optional): Search in key, value, and description
- `groups` (optional): Filter by specific group
- `page` (optional, default: 1): Page number
- `per_page` (optional, default: 10): Items per page
- `sort_by` (optional, default: 'ordering'): Sort column
- `sort_order` (optional, default: 'asc'): Sort direction (asc/desc)

**Response:**

```json
{
    "message": "System parameters retrieved successfully",
    "data": {
        "results": [
            {
                "id": 1,
                "code": "01936a4c-1234-7890-abcd-ef1234567890",
                "groups": "application",
                "key": "app_name",
                "value": "MVP Backend API",
                "ordering": 1,
                "description": "Application name displayed in the system",
                "status": 1,
                "created_at": "2026-02-01T10:48:55.000000Z",
                "updated_at": "2026-02-01T10:48:55.000000Z",
                "created_by": null,
                "updated_by": null
            }
        ],
        "total_item": 12
    }
}
```

### Get Single System Parameter

```
GET /api/sysparams/{id}
Route Name: sysparam.detail
```

**Response:**

```json
{
    "message": "System parameter retrieved successfully",
    "data": {
        "id": 1,
        "code": "01936a4c-1234-7890-abcd-ef1234567890",
        "groups": "application",
        "key": "app_name",
        "value": "MVP Backend API",
        "ordering": 1,
        "description": "Application name displayed in the system",
        "status": 1,
        "created_at": "2026-02-01T10:48:55.000000Z",
        "updated_at": "2026-02-01T10:48:55.000000Z",
        "created_by": null,
        "updated_by": null
    }
}
```

### Create System Parameter

```
POST /api/sysparams
Route Name: sysparam.create
```

**Request Body:**

```json
{
    "groups": "application",
    "key": "new_setting",
    "value": "some value",
    "ordering": 10,
    "description": "Description of the setting"
}
```

**Validation Rules:**

- `groups`: required, string, max 255 characters
- `key`: required, string, max 255 characters
- `value`: required, string
- `ordering`: optional, integer
- `description`: optional, string

**Response:**

```json
{
  "message": "System parameter created successfully",
  "data": { ... }
}
```

### Update System Parameter

```
PUT/PATCH /api/sysparams/{id}
Route Name: sysparam.update
```

**Request Body:** Same as create

**Response:**

```json
{
  "message": "System parameter updated successfully",
  "data": { ... }
}
```

### Delete System Parameter

```
DELETE /api/sysparams/{id}
Route Name: sysparam.delete
```

**Response:**

```json
{
    "message": "System parameter deleted successfully"
}
```

**Note:** This performs a soft delete. The record is not physically removed from the database.

## Default Parameter Groups

The seeder creates parameters in the following groups:

### 1. Application (`application`)

- `app_name`: Application name
- `app_version`: Current version
- `maintenance_mode`: Maintenance mode flag

### 2. Email (`email`)

- `smtp_host`: SMTP server host
- `smtp_port`: SMTP server port
- `from_email`: Default from email address

### 3. Security (`security`)

- `session_timeout`: Session timeout in seconds
- `max_login_attempts`: Maximum login attempts
- `lockout_duration`: Account lockout duration

### 4. Pagination (`pagination`)

- `default_per_page`: Default items per page
- `max_per_page`: Maximum items per page

## Usage Examples

### Filtering by Group

```bash
GET /api/sysparams?groups=security
```

### Searching

```bash
GET /api/sysparams?search=email
```

### Pagination and Sorting

```bash
GET /api/sysparams?page=2&per_page=20&sort_by=key&sort_order=desc
```

### Combined Filters

```bash
GET /api/sysparams?groups=application&search=app&sort_by=ordering
```

## Architecture Compliance

This module strictly follows the project's architectural guidelines:

✅ **CQRS Pattern**: Separate Query (DTOs) and Command objects  
✅ **Dependency Inversion**: Controller depends on Use Cases, Use Cases depend on Repository Interface  
✅ **Repository Pattern**: Interface in Domain, Implementation in Infrastructure  
✅ **Safe Parameter Binding**: All search queries use parameter binding to prevent SQL injection  
✅ **Standard Attributes**: Uses `HasStandardAttributes` trait for UUID, audit fields, and soft deletes  
✅ **Standard Response Format**: Uses `BaseListResource` for consistent API responses  
✅ **Form Request Validation**: Validation logic separated into dedicated Request classes  
✅ **Thin Controllers**: Controllers only handle HTTP concerns, business logic in Use Cases

## Service Provider Binding

The repository interface is bound in `app/Providers/RepositoryServiceProvider.php`:

```php
$this->app->bind(
    SystemParameterRepositoryInterface::class,
    PostgresSystemParameterRepository::class
);
```

## Testing

To test the module:

1. **Run migrations:**

    ```bash
    php artisan migrate
    ```

2. **Seed sample data:**

    ```bash
    php artisan db:seed --class=SystemParameterSeeder
    ```

3. **Test API endpoints:**

    ```bash
    # List all parameters
    curl -X GET http://localhost:8000/api/sysparams \
      -H "Authorization: Bearer {token}"

    # Create a parameter
    curl -X POST http://localhost:8000/api/sysparams \
      -H "Authorization: Bearer {token}" \
      -H "Content-Type: application/json" \
      -d '{
        "groups": "test",
        "key": "test_key",
        "value": "test_value",
        "ordering": 1,
        "description": "Test parameter"
      }'
    ```

## Future Enhancements

Potential improvements for this module:

1. **Caching**: Add Redis caching for frequently accessed parameters
2. **Validation**: Add value type validation (e.g., boolean, integer, JSON)
3. **Versioning**: Track parameter value history
4. **Import/Export**: Bulk import/export of parameters
5. **Environment Override**: Allow environment variables to override parameters
6. **Parameter Types**: Add data type field for automatic type casting
7. **Encryption**: Encrypt sensitive parameter values

## Related Files

- **Model**: `app/Models/SystemParameter.php`
- **Migration**: `database/migrations/2026_02_01_104855_create_system_parameters_table.php`
- **Seeder**: `database/seeders/SystemParameterSeeder.php`
- **Routes**: `routes/api.php` (lines with `sysparams`)
- **Service Provider**: `app/Providers/RepositoryServiceProvider.php`
