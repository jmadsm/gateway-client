# JMA Gateway Client

## Install package
```console
composer require jmadsm/gateway-client
```
## Usage
```php
<?php
use JmaDsm\GatewayClient\Client;
use JmaDsm\GatewayClient\ApiObjects\Product;
use JmaDsm\GatewayClient\ApiObjects\Category;

// Create singleton instance of the client
Client::getInstance( // get the config from JMA
     $config['base_url'],
     $config['access_token'],
     $config['tenant_token']
 );

$product    = Product::get('product_id');
$categories = Category::all();

while ($category = $categories->next()) { // The categories object will recursively fetch all categories in chuncks.
    echo $category->name;
}
```


## Examples
See the examples directory on how to use the different object types.


## How to test your changes before deploying?
Go to examples folder and create config.php file from example file.
After you have added the nessecary data to config.php file, you can test the methods
by running eg. "php examples/products.php" in the terminal.
This will require that your machine has PHP version 8+ set up and configured.
