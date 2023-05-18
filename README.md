Shopping Cart App

The Laravel Shopping Cart App is a simple e-commerce application built with Laravel. It allows users to login, register, browse products, and add them to their cart.

## Installation

To get started with the Shopping Cart App, follow these steps:

1. Clone the repository:

2. Navigate to the project directory:

3. Install the dependencies using Composer: composer install

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the necessary configuration values such as the database credentials.

5. Generate a jwt key: php artisan jwt:secret

6. Run the database migrations: php artisan migrate

7. Optionally, you can seed the database with sample data: php artisan db:seed

8. Start the development server: php artisan serve

9. 9. Access the shopping cart application by visiting `http://localhost:8000` in your browser.

## Features

The Laravel Shopping Cart App provides the following features:

- User registration and authentication.
- Browse products by category or search by keywords.
- Add products to the shopping cart.


