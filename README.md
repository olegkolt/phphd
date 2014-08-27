PHPHD - PHP Hunt for Decedent
=============================
**Found unused code in your project**

**PHPHD** is a library that provides collection and rendering functionality for PHP code coverage information. PHPHD uses **xdebug** for collecting information. PHPHD is similar to the [PHP_CodeCoverage](https://github.com/sebastianbergmann/php-code-coverage), but PHPHD much faster and can be used in web sites.

## Requirements

* PHP 5.3.3 is required but using the latest version of PHP is highly recommended
* [Xdebug](http://xdebug.org/) 2.1.3 is required but using the latest version of Xdebug is highly recommended

## Installation

To add PHPHD as a local, per-project dependency to your project, simply add a dependency on `olegkolt/phphd` to your project's `composer.json` file. Here is a minimal example of a `composer.json` file that just defines a dependency on PHPHD:

    {
        "require": {
            "olegkolt/phphd": "dev-master"
        }
    }

## Using the PHP_CodeCoverage API

### Collect coverage data

```php
<?php

use PHPHD\DataSource\Serialize;
use PHPHD\Collect

$dataSrc = new Serialize('/tmp/phphd/data.dump'); // data.dump - file for saving code coverage data
$collector = new Collect($dataSrc, __DIR__ . '/lib'); // Second argument is code directory path
$collector->startCollection();

// your job

$collector->save();

```
Or just add this code to the entry point of your application:

```php
<?php

use PHPHD\DataSource\Serialize;
use PHPHD\Collect

Collect::register(
    Serialize('/tmp/phphd/data.dump'), // Dump file path
    __DIR__ . '/lib' // Code directory path
);
```
`Collect::register` from the second sample uses `register_shutdown_function` for saving code coverage data.

### Report code coverage data

```php
<?php

use PHPHD\View\Html;
use PHPHD\DataSource\Serialize;

$dataSrc = new Serialize('/tmp/phphd/data.dump');
$html = new Html($dataSrc);
$html->output();
```