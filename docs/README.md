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
use Cndrsdrmn\Warp\Str;

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
use Cndrsdrmn\Warp\Str;

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
use Cndrsdrmn\Warp\Str;

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
use Cndrsdrmn\Warp\Str;

Str::snake('first_name', '-');          // first-name
Str::snake('api-key-value');            // api_key_value
Str::snake('DatabaseConnection');       // database_connection
Str::snake('userIDAndURLPath');         // user_id_and_url_path
Str::snake('mixed-case_input Value');   // mixed_case_input_value
Str::snake('firstName');                // first_name
```