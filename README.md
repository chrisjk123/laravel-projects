# Add projects database tables to a Laravel app

[![Version](https://img.shields.io/packagist/v/chrisjk123/laravel-projects.svg?include_prereleases&style=flat&label=packagist)](https://packagist.org/packages/chrisjk123/laravel-projects)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/chrisjk123/laravel-projects/run-tests?style=flat&label=tests)
[![Quality Score](https://img.shields.io/scrutinizer/g/chrisjk123/laravel-projects.svg?style=flat)](https://scrutinizer-ci.com/g/chrisjk123/laravel-projects)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisjk123/laravel-projects.svg?style=flat)](https://packagist.org/packages/chrisjk123/laravel-projects)

## Table of Contents

* [Introduction](#introduction)
* [Requirements](#requirements)
* [Installation](#installation)
* [Testing](#testing)
* [Usage](#usage)
* [Changelog](#changelog)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

## Introduction

This package is a projects database with maxed out models, migrations and seeders to help get you setup.

## Requirements

This package requires Laravel 5.8 or higher, PHP 7.2 or higher and a database that supports json fields and MySQL compatible functions.

## Installation

> Note: Laravel Projects requires you to have user authentication in place prior to installation.
For Laravel 5.* based projects run the `make:auth` Artisan command.
For Laravel 6.* based projects please see the official guide to get started.

You can install the package via composer:

```bash
composer require chrisjk123/laravel-projects
```

Publish the primary configuration file using the `projects:publish` Artisan command:

```bash
php artisan projects:publish
```

Additionally you may run some seeders to quick start:

```bash
php artisan projects:seed
```

## Testing

Run the tests with:

```bash
composer test
```

## Usage

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email christopherjk123@gmail.com instead of using the issue tracker.

## Credits

- [Christopher Kelker](https://github.com/chrisjk123)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
