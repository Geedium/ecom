<?php 

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');

$twig = new \Twig\Environment($loader, [
    'cache' => 'dist/twig',
    'debug' => true
]);

$template = $twig->load('index.html.twig');
echo $template->render(['products' => [
    (object)[
       'name' => 'Produktas',
       'price' => 1.3
    ],(object)[
        'name'=>'Produktas2'
    ]
  ]
]);
