<?php
declare(strict_types = 1);

namespace Middlewares;

use Interop\Http\Server\MiddlewareInterface;
use JSMin\JSMin;
use Minify_CSS;
use Minify_HTML;

class HtmlMinifier extends Minifier implements MiddlewareInterface
{
    /**
     * @var bool
     */
    private $inlineCss = true;

    /**
     * @var bool
     */
    private $inlineJs = true;

    /**
     * @var string
     */
    protected $mimetype = 'text/html';

    /**
     * Configure if inline css should be minified.
     */
    public function inlineCss(bool $inlineCss = true): self
    {
        $this->inlineCss = $inlineCss;

        return $this;
    }

    /**
     * Configure if inline javascript should be minified.
     */
    public function inlineJs(bool $inlineJs = true): self
    {
        $this->inlineJs = $inlineJs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function minify(string $content): string
    {
        $options = [
            'jsCleanComments' => true,
        ];

        if ($this->inlineCss) {
            $options['cssMinifier'] = function ($css) {
                return Minify_CSS::minify($css, ['preserveComments' => false]);
            };
        }

        if ($this->inlineJs) {
            $options['jsMinifier'] = function ($js) {
                return JSMin::minify($js);
            };
        }

        return Minify_HTML::minify($content, $options);
    }
}
