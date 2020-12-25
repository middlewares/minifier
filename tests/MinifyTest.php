<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use Middlewares\Minifier;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use PHPUnit\Framework\TestCase;

class MinifyTest extends TestCase
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
            Minifier::html(),
            Minifier::css(),
            Minifier::js(),
            function () use ($mime, $content) {
                $response = Factory::createResponse();
                $response->getBody()->write($content);

                return $response->withHeader('Content-Type', $mime);
            },
        ]);

        $this->assertEquals($expected, (string) $response->getBody());
    }
}
