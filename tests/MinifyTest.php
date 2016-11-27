<?php

namespace Middlewares\Tests;

use Middlewares\HtmlMinifier;
use Middlewares\CssMinifier;
use Middlewares\JsMinifier;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\CallableMiddleware;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

class MinifierTest extends \PHPUnit_Framework_TestCase
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
        $response = (new Dispatcher([
            new CssMinifier(),
            new JsMinifier(),
            new HtmlMinifier(),
            new CallableMiddleware(function () use ($mime, $content) {
                $response = new Response();
                $response->getBody()->write($content);

                return $response->withHeader('Content-Type', $mime);
            }),
        ]))->dispatch(new ServerRequest());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertEquals($expected, (string) $response->getBody());
    }
}
