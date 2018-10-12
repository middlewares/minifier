<?php
declare(strict_types = 1);

namespace Middlewares;

use Middlewares\Utils\Traits\HasStreamFactory;
use Middlewares\Utils\Factory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Minifier
{
    use HasStreamFactory;

    /**
     * @var string
     */
    protected $mimetype;

    public function __construct(StreamFactoryInterface $streamFactory = null)
    {
        $this->streamFactory = $streamFactory ?: Factory::getStreamFactory();
    }

    /**
     * Process a server request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (stripos($response->getHeaderLine('Content-Type'), $this->mimetype) === 0) {
            $stream = $this->createStream($this->minify((string) $response->getBody()));

            return $response->withBody($stream)
                ->withoutHeader('Content-Length');
        }

        return $response;
    }

    /**
     * Minify the body content.
     */
    abstract protected function minify(string $content): string;
}
