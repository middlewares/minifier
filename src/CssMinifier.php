<?php

namespace Middlewares;

use Interop\Http\Server\MiddlewareInterface;
use Minify_CSS;

class CssMinifier extends Minifier implements MiddlewareInterface
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
