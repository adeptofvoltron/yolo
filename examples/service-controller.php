<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HelloController
{
    public function worldAction(Request $request)
    {
        return new Response("Hallo welt, got swag yo!\n");
    }
}

$container = Yolo\createContainer(
    [
        'debug' => true,
    ],
    [
        new Yolo\DependencyInjection\MonologExtension(),
        new Yolo\DependencyInjection\ServiceControllerExtension(),
        new Yolo\DependencyInjection\CallableExtension(
            'controller',
            function (array $config, ContainerBuilder $container) {
                $container->register('hello.controller', 'HelloController');
            }
        ),
    ]
);

$app = new Yolo\Application($container);

$app->get('/', 'hello.controller:worldAction');

$app->run();
