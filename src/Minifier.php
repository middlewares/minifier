<?php
declare(strict_types = 1);

namespace Middlewares;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WyriHaximus\Compress\CompressorInterface;
use WyriHaximus\CssCompress\Factory as CssFactory;
use WyriHaximus\HtmlCompress\Factory as HtmlFactory;
use WyriHaximus\JsCompress\Factory as JsFactory;

class Minifier implements MiddlewareInterface
{
    /**
     * @var CompressorInterface
     */
    private $compressor;

    /**
     * @var string
     */
    protected $mimetype;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    public static function html(StreamFactoryInterface $streamFactory = null): self
    {
        return new static(HtmlFactory::construct(), 'text/html', $streamFactory);
    }

    public static function css(StreamFactoryInterface $streamFactory = null): self
    {
        return new static(CssFactory::construct(), 'text/css', $streamFactory);
    }

    public static function js(StreamFactoryInterface $streamFactory = null): self
    {
        return new static(JsFactory::construct(), 'text/javascript', $streamFactory);
    }

    public function __construct(
        CompressorInterface $compressor,
        string $mimetype,
        StreamFactoryInterface $streamFactory = null
    ) {
        $this->compressor = $compressor;
        $this->mimetype = $mimetype;
        $this->streamFactory = $streamFactory ?: Factory::getStreamFactory();
    }

    /**
     * Process a server request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if (stripos($response->getHeaderLine('Content-Type'), $this->mimetype) === 0) {
            $stream = $this->streamFactory->createStream($this->minify((string) $response->getBody()));

            return $response->withBody($stream)
                ->withoutHeader('Content-Length');
        }

        return $response;
    }

    private function minify(string $source): string
    {
        return $this->compressor->compress($source);
    }
}
