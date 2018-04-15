# Reaction Library

![Travis](https://img.shields.io/travis/Aaronmacaron/reaction.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/aaronmacaron/reaction.svg?style=flat-square)


This library makes it easy to handle reactions of actions, methods and functions. If you are dealing with methods that can either be successful or fail and want more information about the result of the method, you can use a reaction.

## Installation

You can install reaction using [Composer](https://getcomposer.org/):

```bash
$ composer require aaronmacaron/reaction
``` 

To install and use the reaction library you need PHP version 7.1 or newer.

## Example

You can use this library as follows:

```php
<?php

use Aaronmacaron\Reaction\Reaction;

include __DIR__ . "/vendor/autoload.php";

function validatePassword(string $password): Reaction
{
    if (empty($password)) {
        return Reaction::failure("The password must not be empty!");
    }

    if (strlen($password) >= 8) {
        return Reaction::success();
    }

    return Reaction::failure("The password must be at least eight chars long.");
}

validatePassword("secret")
    ->succeed(function () {
        echo "Password is valid" . PHP_EOL;
    })->fail(function (Reaction $reaction) {
        echo "The password is not valid: " . $reaction->getMessage() . PHP_EOL;
    });

// Output: The password is not valid: The password must be at least eight chars long.
```