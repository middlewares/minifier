<?php

namespace Middlewares\Tests;

use PHPUnit\Framework\TestCase;
use Middlewares\HtmlMinifier;
use Middlewares\CssMinifier;
use Middlewares\JsMinifier;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;

class MinifierTest extends TestCase
{
    public function minifierProvider()
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
    public function testMinifier($mime, $content, $expected)
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
}