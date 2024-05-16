# PetStore Application

This is a Laravel application that interacts with the PetStore API. It allows users to perform CRUD operations on pets,
including creating, retrieving, updating, and deleting pets.

## Requirements

- PHP 8.0 or higher
- Composer
- Laravel 8 or higher
- Docker

## Installation

1. **Clone the repository:**
2. **Install dependencies:**
    ```bash
    composer install
    ```
3. **Copy the `.env.example` file to `.env` and update the database configuration:**
    ```bash
    cp .env.example .env
    ```
4. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```
5. **Run the database migrations:**
    ```bash
    php artisan migrate
    ```
6. **Install NPM dependencies:**
   ```bash
   npm install
   ```
7. **Start docker containers:**
   ```bash
   ./vendor/bin/sail up
   ```
8. **Enter the container:**
   ```bash
   ./vendor/bin/sail shell
   ```
9. **Run the application:**
   ```bash
   npm run dev
   ```
10. **Access the application in your browser:**
    ```
    http://localhost
    ```

## Testing

From sail shell run:

```bash
php artisan test
```


