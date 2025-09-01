
# hwai-env-lib

`hwai-env-lib` is a modern PHP library designed to simplify the management of `.env` files in your projects. It provides a clean, object-oriented API for loading, parsing, and manipulating environment variables, following international standards such as PSR-4 autoloading and Composer support. The library is released under the MIT license, making it free and open-source for both personal and commercial use.

## Features

- **Easy Loading:** Instantly load and parse `.env` files with a single line of code.
- **Comment Support:** Ignores lines starting with `#` or `;` for easy documentation within your `.env` files.
- **Whitespace & Quotes Handling:** Automatically trims whitespace and removes single/double quotes from values.
- **Type Casting:** Converts values like `true`, `false`, `null`, integers, and floats to their native PHP types.
- **Convenient API:** Get, set, check, and list environment variables with simple methods.
- **Save Changes:** Persist your environment changes back to a file.
- **PSR-4 Autoloading:** Fully compatible with Composer and modern PHP standards.
- **Unit Tested:** Includes PHPUnit tests for reliability.

## Why Usehwai-env-lib?

Managing environment variables is essential for configuring applications across different environments (development, staging, production). `hwai-env-lib` makes this process robust and developer-friendly, reducing errors and improving maintainability. It is ideal for any PHP project that needs flexible configuration management.

## Installation

```bash
composer require ahmetasaad/hwai-env-lib