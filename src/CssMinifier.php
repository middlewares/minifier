<?php

namespace Middlewares;

use Interop\Http\Middleware\ServerMiddlewareInterface;
use Minify_CSS;

class CssMinifier extends Minifier implements ServerMiddlewareInterface
{
    /**
     * @var string
     */
    protected $mimetype = 'text/css';

    /**
     * {@inheritdoc}
     */
    protected function minify($content)
    {
        return Minify_CSS::minify($content, ['preserveComments' => false]);
    }
}
