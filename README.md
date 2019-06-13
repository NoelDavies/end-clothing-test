# Set-up
Create a new sqlite database in `./databases/database.sqlite`, This can be done using the following command from the project root 
```
touch ./database/database.sqlite
```

Migrate the database installation from the terminal using the following command from the project root
```
php artisan migrate:install
```

## Usage
There are 3 routes available

#### `PUT` `/api/v1/shipping-rates/{rate-name}`
The rate name should be slugged (`A-Za-z\-_`), and include the following data:
```
    'name'         => 'JP Shipping Rate',
    'country_code' => 'JP',
    'from_value'   => 0,
    'to_value'     => 50,
    'weight'       => 20,
    'shipping_fee' => 70,
```

Where name is the readable name of the slug and the from_value, to_value, weight and shipping_fee are all integers.
(The brief didn't include a note on floats, so it wasn't included. I'd ideally use a proper currency library that uses BCMath and strings to handle floating points.)

 #### `GET` `/api/v1/shipping-rates/{rate-name}`
 The rate name should be slugged (`A-Za-z\-_`), The response will be formatted as below
 ```
 {
    "price": 100,
    "weight": 40,
    "country_code": "MX",
    "shipping_fee": 40,
    "total": 140
}
 ```
 
 #### `DELETE` `/api/v1/shipping-rates/{rate-name}`
 The rate name should be slugged (`A-Za-z\-_`), The response will be a 200 response code on success. Or a 401 if the rate doesn't exist.