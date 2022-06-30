# New-Tel PHP Library

## Installing

The recommended way to install NewTel is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest version of NewTel:

```bash
php composer.phar require alexshangin/new-tel:dev-master
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update NewTel using composer:

 ```bash
composer.phar update
 ```

## Quick Examples
# Make call

```php
<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use NewTel\NewTel;

// Instantiate an NewTel instance.
$keyNewtel = '0123456789012345678912344564984984984dfd9fafb48';
$writeKey = 'd654cbb5dc5b6ad5fc6d54bd8f4b9d1c21d95bd95c1bd94';

$newTel = new NewTel($keyNewtel, $writeKey);
$newTel->makeCall('71234567890', '1234');

```
