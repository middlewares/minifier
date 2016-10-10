<?php

namespace Middlewares;

use Interop\Http\Middleware\MiddlewareInterface;
use Minify_HTML;
use Minify_CSS;
use JSMin;

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
     *
     * @param bool $inlineCss
     *
     * @return self
     */
    public function inlineCss($inlineCss = true)
    {
        $this->inlineCss = $inlineCss;

        return $this;
    }

    /**
     * Configure if inline javascript should be minified.
     *
     * @param bool $inlinejs
     *
     * @return self
     */
    public function inlineJs($inlinejs = true)
    {
        $this->inlinejs = $inlinejs;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function minify($content)
    {
        $options = [
            'jsCleanComments' => true
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
