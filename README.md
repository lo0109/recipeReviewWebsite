# Recipe Sharing Website

This is a Laravel-based website for Recipe Share and Review, built using PHP and an SQLite3 database. The project provides a platform for users to create, edit, delete and review recipes.

## Requirements

To run this project locally, ensure you have the following installed:

- PHP (>= 7.4)
- Composer
- Laravel Framework
- SQLite3

## Installation

Follow these steps to get the project running on your local machine.

1. **Clone the repository**:
    ```bash
    git clone https://github.com/lo0109/recipeReviewWebsite.git
    cd recipeReviewWebsite
    ```

2. **Install dependencies**:  
    Make sure you have [Composer](https://getcomposer.org/) installed, then run:
    ```bash
    composer install
    ```

3. **Set up the environment file**:  
    Copy the `.env.example` file and rename it to `.env`:
    ```bash
    cp .env.example .env
    ```

4. **Generate application key**:  
    Run the following command to generate the application key:
    ```bash
    php artisan key:generate
    ```

5. **Set up the database**:  
    Laravel uses SQLite3 by default in this project. There is already a SQLite file and create.sql in the `database/` directory. :
    ```bash
    touch database/database.sqlite
    ```

6. **Create table in database**:  
    Run the create.sql file to create the tables and sample data:
    ```bash
    sqlite3 database/database.sqlite
    .read database/create.sql
    ```

7. **Serve the application**:  
    You can now start the local development server using Laravel’s artisan command:
    ```bash
    php artisan serve
    ```

    By default, the website will be accessible at `http://localhost:8000`.

## Usage

- Access the website from your browser by navigating to `http://localhost:8000`.
- You can register a user account and begin submitting peer reviews.

## Contributing

Feel free to fork this repository and submit a pull request if you wish to contribute to the project. Contributions are welcome!
