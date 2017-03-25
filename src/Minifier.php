<?php

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Middlewares\Utils\Helpers;

abstract class Minifier
{
    /**
     * @var string
     */
    protected $mimetype;

    /**
     * Process a server request and return a response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);

        if (stripos($response->getHeaderLine('Content-Type'), $this->mimetype) === 0) {
            $stream = Utils\Factory::createStream();
            $stream->write($this->minify((string) $response->getBody()));

            $response = $response->withBody($stream);

            return Helpers::fixContentLength($response);
        }

        return $response;
    }

    /**
     * Minify the body content.
     *
     * @param string $content
     *
     * @return string
     */
    abstract protected function minify($content);
}
