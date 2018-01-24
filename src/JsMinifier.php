<?php
declare(strict_types = 1);

namespace Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use JSMin\JSMin;

class JsMinifier extends Minifier implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $mimetype = 'text/javascript';

    /**
     * {@inheritdoc}
     */
    protected function minify(string $content): string
    {
        return JSMin::minify($content);
    }
}
