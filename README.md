# middlewares/minifier

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
![Testing][ico-ga]
[![Total Downloads][ico-downloads]][link-downloads]

Middleware to minify the `Html`, `CSS` and `Javascript` content using [wyrihaximus/compress](https://github.com/WyriHaximus/php-compress) and the following compressors by default:

- [wyrihaximus/html-compress](https://github.com/WyriHaximus/HtmlCompress)
- [wyrihaximus/css-compress](https://github.com/WyriHaximus/php-css-compress)
- [wyrihaximus/js-compress](https://github.com/WyriHaximus/php-js-compress)

## Requirements

* PHP >= 7.2
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/minifier](https://packagist.org/packages/middlewares/minifier).

```sh
composer require middlewares/minifier
```

## Example

```php
Dispatcher::run([
    Middlewares\Minifier::html(),
    Middlewares\Minifier::css(),
    Middlewares\Minifier::js(),
]);
```

## Usage

This middleware minify the code of http responses using any compressor implementing the `WyriHaximus\Compress\CompressorInterface`. The code format is detected from the `Content-Type` header, so make sure your responses contains this header (you may want to use [middlewares/negotiation](https://github.com/middlewares/negotiation) for that).

```php
use WyriHaximus\HtmlCompress\Factory;

$compressor = Factory::construct();
$mimeType = 'text/html';

$minifier = new Middlewares\Minifier($compressor, $mimeType);
```

Optionally, you can provide a `Psr\Http\Message\StreamFactoryInterface` as third argument to create the response body. If it's not defined, [Middleware\Utils\Factory](https://github.com/middlewares/utils#factory) will be used to detect it automatically.

```php
$streamFactory = new MyOwnStreamFactory();

$minifier = new Middlewares\Minifier($compressor, $mimeType, $streamFactory);
```

### Helpers

Three static functions are provided to create instances of this middleware with common configuration for html, css and js responses:

```php
$htmlMinifier = Middlewares\Minifier::html();
$cssMinifier = Middlewares\Minifier::css();
$jsMinifier = Middlewares\Minifier::js();
```

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/minifier.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ga]: https://github.com/middlewares/minifier/workflows/testing/badge.svg
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/minifier.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/minifier
[link-downloads]: https://packagist.org/packages/middlewares/minifier
