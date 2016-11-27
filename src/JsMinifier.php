<?php

namespace Middlewares;

use Interop\Http\Middleware\ServerMiddlewareInterface;
use JSMin;

class JsMinifier extends Minifier implements ServerMiddlewareInterface
{
    /**
     * @var string
     */
    protected $mimetype = 'text/javascript';

    /**
     * {@inheritdoc}
     */
    protected function minify($content)
    {
        return JSMin::minify($content);
    }
}
