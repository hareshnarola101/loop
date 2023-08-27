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

```makefile
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loop
DB_USERNAME=root
DB_PASSWORD=
```

1. Run migrations to set up the database:
```bash 
php artisan migrate
```

1. Run the development server:
```bash 
php artisan serve
```

Now you can access the API at http://127.0.0.1:8000.


<h3>Importing Master Data</h3>
To import master data from CSV files, use the following Artisan command:
```bash
php artisan import:data
```

This command imports customer and product data from provided URLs into the database. The import results will be logged.


<h3>Order API</h3>
The following endpoints are available for managing orders:

<li>GET http://127.0.0.1:8000/api/orders: Get a list of all orders.</li>

<li>POST http://127.0.0.1:8000/api/orders: Create a new order.</li>

Request Body:

```json
{
    "customer_id": 5,
    "product_ids": [ 1, 2 ]
}
```

<li>GET http://127.0.0.1:8000/api/orders/{id}: Get details of a specific order.</li>

<li>PUT http://127.0.0.1:8000/api/orders/{id}: Update an order.</li>

Request Body:

```json
{
    "customer_id":5,
    "product_ids":[ 56, 60]
}
```

<li>DELETE http://127.0.0.1:8000/api/orders/{id}: Delete an order.</li>

<h3>Add Product to Order Endpoint</h3>
To attach a product to an existing order, use the following endpoint:

<li>POST http://127.0.0.1:8000/api/orders/{id}/add</li>

Request Body:

```json
{
    "product_id": 55
}
```


<h3>Pay Order Endpoint</h3>
To pay for an order, use the following endpoint:

<li>POST http://127.0.0.1:8000/api/orders/{id}/pay</li>
Request Body:

```json
{
    "order_id": 23,
    "customer_email": "user@email.com",
    "value": 33.4
}
```

Payment Response Success:

```json
{
    "message": "Payment Successful"
}
```

Payment Response Failed:
```json
{
    "message": "Insufficient Funds"
}
```

<h3>Contributing</h3>
Contributions are welcome! Feel free to open issues or submit pull requests.

<h3>License</h3>
This project is licensed under the MIT License.

<h2>Note:</h2>
<b>Here in root folder I have attached exported db file of database and json file of postmen collection</b>

<h2>Estimated and tracked time</h2>

<table>
  <tr>
    <th>Task</th>
    <th>Estimated Time</th>
    <th>Tracked Time</th>
  </tr>
  <tr>
    <td>Import master data</td>
    <td>45 minute</td>
    <td>33 minute</td>
  </tr>
  <tr>
    <td>Expose Order Data as REST Service</td>
    <td>1hour 30minute</td>
    <td>1hour 15min</td>
  </tr>
  <tr>
    <td>Create Add-Product-to-Order Endpoint</td>
    <td>40 minutes</td>
    <td>34 minutes</td>
  </tr>
  <tr>
    <td>Create Pay Order Endpoint</td>
    <td>45 minutes</td>
    <td>29 minytes</td>
  </tr>
</table>