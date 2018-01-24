<?php
declare(strict_types = 1);

namespace Middlewares;

use Minify_CSS;
use Psr\Http\Server\MiddlewareInterface;

class CssMinifier extends Minifier implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $mimetype = 'text/css';

    /**
     * {@inheritdoc}
     */
    protected function minify(string $content): string
    {
        return Minify_CSS::minify($content, ['preserveComments' => false]);
    }
}
