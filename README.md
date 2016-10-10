# middlewares/minifier

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabs Insight][ico-sensiolabs]][link-sensiolabs]

Middleware to minify the `Html`, `CSS` and `Javascript` content using [mrclay/minify](https://github.com/mrclay/minify). This package is splited into the following components:

* [HtmlMinifier](#htmlminifier)
* [CssMinifier](#cssminifier)
* [JsMinifier](#jsminifier)

## Requirements

* PHP >= 5.6
* A [PSR-7](https://packagist.org/providers/psr/http-message-implementation) http mesage implementation ([Diactoros](https://github.com/zendframework/zend-diactoros), [Guzzle](https://github.com/guzzle/psr7), [Slim](https://github.com/slimphp/Slim), etc...)
* A [PSR-15](https://github.com/http-interop/http-middleware) middleware dispatcher ([Middleman](https://github.com/mindplay-dk/middleman), etc...)

## Installation

This package is installable and autoloadable via Composer as [middlewares/minifier](https://packagist.org/packages/middlewares/minifier).

```sh
composer require middlewares/minifier
```

## Example

```php
$dispatcher = new Dispatcher([
    new Middlewares\CssMinify(),
    new Middlewares\JsMinify(),
	new Middlewares\HtmlMinify(),
]);

$response = $dispatcher->dispatch(new Request());
```

## HtmlMinifier

Minifies the code of html responses. Make sure the response contains the header `Content-Type: text/html` (you can use [middlewares/negotiation](https://github.com/middlewares/negotiation)).

#### `inlineCss($inlineCss = true)`

Set `false` to do not minify inline css. (`true` by default)

#### `inlineJs($inlineJs = true)`

Set `false` to do not minify inline js. (`true` by default)

## CssMinifier

Minifies the code of css responses. Make sure the response contains the header `Content-Type: text/css`.

## JsMinifier

Minifies the code of javascript responses. Make sure the response contains the header `Content-Type: text/javascript`.


---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/minifier.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/minifier/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/minifier.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/minifier.svg?style=flat-square
[ico-sensiolabs]: https://img.shields.io/sensiolabs/i/36786f5a-2a15-4399-8817-8f24fcd8c0b4.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/minifier
[link-travis]: https://travis-ci.org/middlewares/minifier
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/minifier
[link-downloads]: https://packagist.org/packages/middlewares/minifier
[link-sensiolabs]: https://insight.sensiolabs.com/projects/36786f5a-2a15-4399-8817-8f24fcd8c0b4
