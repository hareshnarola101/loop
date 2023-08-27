# API Web Shop

Welcome to the API Web Shop project! This is a simplified mini web shop implementation that consists of customers, products, and orders. The goal of this project is to import CSV data, create an API for managing orders, and integrate a payment system.

## Getting Started

### Installation

1. Clone the repository to your local machine:

```bash
git clone https://github.com/hareshnarola101/loop
```

1. Navigate to the project directory:

```bash
cd loop
```

1. Install the required dependencies:
``````bash
composer install
``````

Usage
1. Configure your database settings in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_webshop
DB_USERNAME=root
DB_PASSWORD=

1. Run migrations to set up the database:
php artisan migrate

1. Run the development server:
php artisan serve


Now you can access the API at http://127.0.0.1:8000.


Importing Master Data
To import master data from CSV files, use the following Artisan command:


php artisan import:data

This command imports customer and product data from provided URLs into the database. The import results will be logged.


Order API
The following endpoints are available for managing orders:

GET /api/orders: Get a list of all orders.

POST /api/orders: Create a new order.
Request Body:
{
    "customer_id": 5,
    "product_ids": [ 1, 2 ]
}

GET /api/orders/{id}: Get details of a specific order.

PUT /api/orders/{id}: Update an order.
Request Body:
{
    "customer_id":5,
    "product_ids":[ 56, 60]
}

DELETE /api/orders/{id}: Delete an order.

Add Product to Order Endpoint
To attach a product to an existing order, use the following endpoint:

POST /api/orders/{id}/add

Request Body:
{
    "product_id": 55
}


Pay Order Endpoint
To pay for an order, use the following endpoint:

POST /api/orders/{id}/pay
Request Body:

{
    "order_id": 23,
    "customer_email": "user@email.com",
    "value": 33.4
}


Payment Response Success:

{
    "message": "Payment Successful"
}

Payment Response Failed:

{
    "message": "Insufficient Funds"
}

Contributing
Contributions are welcome! Feel free to open issues or submit pull requests.

License
This project is licensed under the MIT License.