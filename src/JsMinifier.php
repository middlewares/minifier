<?php

namespace Middlewares;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use JSMin;

class JsMinifier extends Minifier implements MiddlewareInterface
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
