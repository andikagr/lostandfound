# Lost & Found

is a robust RESTful API built with Laravel designed to manage lost and found items. It provides a secure and efficient way for users to report lost items, register found items, and claim items.

## Features

-   **Authentication**: Secure user registration and login using Laravel Sanctum (Bearer Token).
-   **Lost Item Reporting**: Users can report lost items with details like location, category, and images.
-   **Found Item Reporting**: Users can register items they found to help return them to owners.
-   **Claim System**: Users can claim found items by providing proof of ownership.
-   **History**: Users can view their allocated reports and claim history.
-   **Image Uploads**: Support for uploading images for items and proof of claims.

## Tech Stack

-   **Framework**: [Laravel](https://laravel.com)
-   **Language**: PHP 8.2+
-   **Database**: MySQL
-   **Authentication**: Laravel Sanctum

## Installation

Follow these steps to set up the project locally.

### Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL

### Steps

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yourusername/lostandfounditem.git
    cd lostandfounditem
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Setup**
    Copy the `.env` file and configure your database credentials.
    ```bash
    cp .env.example .env
    ```
    Open `.env` and set your database details:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations**
    ```bash
    php artisan migrate
    ```

6.  **Create Storage Symlink** (for images)
    ```bash
    php artisan storage:link
    ```

7.  **Serve the Application**
    ```bash
    php artisan serve
    ```
    The API will be available at `http://localhost:8000/api`.

## API Documentation

The API uses **Bearer Token** authentication. Include `Authorization: Bearer <your-token>` in the header for protected routes.

### Authentication

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Login and get token |
| `POST` | `/api/logout` | Logout (Revoke token) |
| `GET` | `/api/user` | Get authenticated user info |

### Lost Items

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/lost-items` | Get list of lost items |
| `POST` | `/api/lost-items` | Report a lost item |
| `GET` | `/api/lost-items/{id}` | Get detail of a lost item |
| `PUT` | `/api/lost-items/{id}` | Update lost item report |
| `DELETE` | `/api/lost-items/{id}` | Delete lost item report |

### Found Items

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/found-items` | Get list of found items (Public) |
| `POST` | `/api/found-items` | Report a found item |
| `PUT` | `/api/found-items/{id}` | Update found item report |
| `DELETE` | `/api/found-items/{id}` | Delete found item report |

### Claims

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/found-items/{id}/claim` | Claim a found item |
| `PUT` | `/api/claim-items/{id}` | Update a claim |
| `DELETE` | `/api/claim-items/{id}` | Delete a claim |

### History

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/history` | Get user's report history |

## Usage Example

### Login
**Request:**
```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "message": "Login success",
    "access_token": "1|AbCdEf123456...",
    "token_type": "Bearer"
}
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
