<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use Middlewares\CssMinifier;
use Middlewares\HtmlMinifier;
use Middlewares\JsMinifier;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use PHPUnit\Framework\TestCase;

class MinifierTest extends TestCase
{
    public function minifierProvider(): array
    {
        $data = [
            [
                'text/html',
                file_get_contents(__DIR__.'/assets/test.html'),
                trim(file_get_contents(__DIR__.'/assets/test.min.html')),
            ],
            [
                'text/css',
                file_get_contents(__DIR__.'/assets/test.css'),
                trim(file_get_contents(__DIR__.'/assets/test.min.css')),
            ],
            [
                'text/javascript',
                file_get_contents(__DIR__.'/assets/test.js'),
                trim(file_get_contents(__DIR__.'/assets/test.min.js')),
            ],
        ];

        return $data;
    }

    /**
     * @dataProvider minifierProvider
     */
    public function testMinifier(string $mime, string $content, string $expected)
    {
        $response = Dispatcher::run([
            new CssMinifier(),
            new JsMinifier(),
            new HtmlMinifier(),
            function () use ($mime, $content) {
                $response = Factory::createResponse();
                $response->getBody()->write($content);

                return $response->withHeader('Content-Type', $mime);
            },
        ]);

        $this->assertEquals($expected, (string) $response->getBody());
    }

    public function testHtmlOnlyMinifier()
    {
        $response = Dispatcher::run([
            (new HtmlMinifier())
                ->inlineCss(false)
                ->inlineJs(false),
            function () {
                echo file_get_contents(__DIR__.'/assets/test.html');
                return Factory::createResponse()->withHeader('Content-Type', 'text/html');
            },
        ]);

        $expected = trim(file_get_contents(__DIR__.'/assets/test-html.min.html'));

        $this->assertEquals($expected, (string) $response->getBody());
    }
}
