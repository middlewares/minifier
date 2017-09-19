<?php

namespace Middlewares;

use Interop\Http\Server\RequestHandlerInterface;
use Middlewares\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Minifier
{
    /**
     * @var string
     */
    protected $mimetype;

    /**
     * Process a server request and return a response.
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $response = $handler->handle($request);

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
