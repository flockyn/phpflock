# PHP Flock - Documentation

Welcome to the PHP Flock documentation.  
PHP Flock is a comprehensive collection of optimized, developer-friendly static helper methods designed to simplify common operations across various data types and programming challenges in PHP.
It aims to reduce boilerplate and boost development efficiency.

## Installation

Install the package via Composer:

```shell
composer require flockyn/phpflock
```

## Utilities

### Array

The `Arr` class provides a robust and flexible collection of array manipulation methods.
These utilities are designed to simplify common data transformation tasks, such as key casing and advanced mapping, in a clear and non-destructive manner.

#### Available Methods

- [Arr::keyCase](#method-array-key-case)
- [Arr::mapWithKeys](#method-array-map-with-keys)
- [Arr::toCamelKeys](#method-array-to-camel-keys)
- [Arr::toKebabKeys](#method-array-to-kebab-keys)
- [Arr::toPascalKeys](#method-array-to-pascal-keys)
- [Arr::toSnakeKeys](#method-array-to-snake-keys)

<a name="method-array-key-case"></a>
##### `Arr::keyCase()`

The `Arr::keyCase` method changes the case of array keys to a specified style.
It supports recursive traversal with depth control and also accepts custom casing callbacks.

###### Enum Values

When using the `ArrKeyCase` enum, the following cases are available:

| Enum                 | Example Conversion |
|----------------------|--------------------|
| `ArrKeyCase::Camel`  | `camelCase`        |
| `ArrKeyCase::Kebab`  | `kebab-case`       |
| `ArrKeyCase::Pascal` | `PascalCase`       |
| `ArrKeyCase::Snake`  | `snake_case`       |

```php
use Flockyn\PHPFlock\Arr;
use Flockyn\PHPFlock\Enums\ArrKeyCase;

$array = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => [
        'street_name' => 'Main Street',
        'postal_code' => '12345',
    ],
];

$camel = Arr::keyCase($array, ArrKeyCase::Camel);

/*
    [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'address' => [
            'streetName' => 'Main Street',
            'postalCode' => '12345',
        ],
    ]
*/
```

You may also use a custom callback to transform the key:

```php
$upper = Arr::keyCase($array, fn ($key) => strtoupper($key));

/*
    [
        'FIRST_NAME' => 'John',
        'LAST_NAME' => 'Doe',
        'ADDRESS' => [
            'STREET_NAME' => 'Main Street',
            'POSTAL_CODE' => '12345',
        ],
    ]
*/
```

You may limit the transformation depth by passing the number of levels to transform:

```php
$shallow = Arr::keyCase($array, ArrKeyCase::Camel, 1);

/*
    [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'address' => [
            'street_name' => 'Main Street',
            'postal_code' => '12345',
        ],
    ]
*/
```
<a name="method-array-map-with-keys"></a>
##### `Arr::mapWithKeys()`

The `Arr::mapWithKeys` method maps an array into a new array by running each value through a callback.
The callback must return an associative array of key-value pairs:

```php
use Flockyn\PHPFlock\Arr;

$array = [
    ['id' => 1, 'name' => 'John'],
    ['id' => 2, 'name' => 'Jane'],
];

$result = Arr::mapWithKeys($array, fn ($item) => [
    $item['id'] => $item['name'],
]);

// [1 => 'John', 2 => 'Jane']
```

<a name="method-array-to-camel-keys"></a>
##### `Arr::toCamelKeys()`

The `Arr::toCamelKeys` method converts all array keys to `camelCase`:

```php
use Flockyn\PHPFlock\Arr;

$array = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => [
        'street_name' => 'Main Street',
        'postal_code' => '12345',
    ],
];

$camel = Arr::toCamelKeys($array);

/*
    [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'address' => [
            'streetName' => 'Main Street',
            'postalCode' => '12345',
        ],
    ]
*/
```

Depth control is supported:

```php
$shallow = Arr::toCamelKeys($array, 1);

/*
    [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'address' => [
            'street_name' => 'Main Street',
            'postal_code' => '12345',
        ],
    ]
*/
```

<a name="method-array-to-kebab-keys"></a>
##### `Arr::toKebabKeys()`

The `Arr::toKebabKeys` method converts all array keys to `kebab-case`:

```php
use Flockyn\PHPFlock\Arr;

$array = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => [
        'street_name' => 'Main Street',
        'postal_code' => '12345',
    ],
];

$kebab = Arr::toKebabKeys($array);

/*
    [
        'first-name' => 'John',
        'last-name' => 'Doe',
        'address' => [
            'street-name' => 'Main Street',
            'postal-code' => '12345',
        ],
    ]
*/
```

Depth control is supported:

```php
$shallow = Arr::toKebabKeys($array, 1);

/*
    [
        'first-name' => 'John',
        'last-name' => 'Doe',
        'address' => [
            'street_name' => 'Main Street',
            'postal_code' => '12345',
        ],
    ]
*/
```

<a name="method-array-to-pascal-keys"></a>
##### `Arr::toPascalKeys()`

The `Arr::toPascalKeys` method converts all array keys to `PascalCase`:

```php
use Flockyn\PHPFlock\Arr;

$array = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => [
        'street_name' => 'Main Street',
        'postal_code' => '12345',
    ],
];

$pascal = Arr::toPascalKeys($array);

/*
    [
        'FirstName' => 'John',
        'LastName' => 'Doe',
        'Address' => [
            'StreetName' => 'Main Street',
            'PostalCode' => '12345',
        ],
    ]
*/
```

Depth control is supported:

```php
$shallow = Arr::toPascalKeys($array, 1);

/*
    [
        'FirstName' => 'John',
        'LastName' => 'Doe',
        'Address' => [
            'street_name' => 'Main Street',
            'postal_code' => '12345',
        ],
    ]
*/
```

<a name="method-array-to-snake-keys"></a>
##### `Arr::toSnakeKeys()`

The `Arr::toSnakeKeys` method converts all array keys to `snake_case`:

```php
use Flockyn\PHPFlock\Arr;

$array = [
    'first Name' => 'John',
    'lastName' => 'Doe',
    'address' => [
        'StreetName' => 'Main Street',
        'PostalCode' => '12345',
    ],
];

$snake = Arr::toSnakeKeys($array);

/*
    [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'address' => [
            'street_name' => 'Main Street',
            'postal_code' => '12345',
        ],
    ]
*/
```

Depth control is supported:

```php
$shallow = Arr::toSnakeKeys($array, 1);

/*
    [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'address' => [
            'StreetName' => 'Main Street',
            'PostalCode' => '12345',
        ],
    ]
*/
```

### String

The `Str` class provides a variety of convenient functions for working with strings.
These helpers make it easy to transform values into consistent formats, normalize naming conventions, and perform common string manipulations in a clean and expressive way.

#### Available Methods

- [Str::camel](#method-string-camel)
- [Str::kebab](#method-string-kebab)
- [Str::pascal](#method-string-pascal)
- [Str::snake](#method-string-snake)

<a name="method-string-camel"></a>
##### `Str::camel()`

The `Str::camel` method converts the given string to `camelCase`:

```php
use Flockyn\PHPFlock\Str;

Str::camel('first_name');               // firstName
Str::camel('api-key-value');            // apiKeyValue
Str::camel('DatabaseConnection');       // databaseConnection
Str::camel('userIDAndURLPath');         // userIdAndUrlPath
Str::camel('mixed-case_input Value');   // mixedCaseInputValue
Str::camel('firstName');                // firstName
```

<a name="method-string-kebab"></a>
##### `Str::kebab()`

The `Str::kebab` method converts the given string to `kebab-case`:

```php
use Flockyn\PHPFlock\Str;

Str::kebab('first_name');               // first-name
Str::kebab('api-key-value');            // api-key-value
Str::kebab('DatabaseConnection');       // database-connection
Str::kebab('userIDAndURLPath');         // user-id-and-url-path
Str::kebab('mixed-case_input Value');   // mixed-case-input-value
Str::kebab('firstName');                // first-name
```

<a name="method-string-pascal"></a>
##### `Str::pascal()`

The `Str::pascal` method converts the given string to `PascalCase`:

```php
use Flockyn\PHPFlock\Str;

Str::pascal('first_name');               // FirstName
Str::pascal('api-key-value');            // ApiKeyValue
Str::pascal('DatabaseConnection');       // DatabaseConnection
Str::pascal('userIDAndURLPath');         // UserIdAndUrlPath
Str::pascal('mixed-case_input Value');   // MixedCaseInputValue
Str::pascal('firstName');                // FirstName
```

<a name="method-string-snake"></a>
##### `Str::snake()`

The `Str::snake` method converts the given string to `snake_case`.
You may also specify a custom separator:

```php
use Flockyn\PHPFlock\Str;

Str::snake('first_name', '-');          // first-name
Str::snake('api-key-value');            // api_key_value
Str::snake('DatabaseConnection');       // database_connection
Str::snake('userIDAndURLPath');         // user_id_and_url_path
Str::snake('mixed-case_input Value');   // mixed_case_input_value
Str::snake('firstName');                // first_name
```