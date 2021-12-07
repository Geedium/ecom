<?php

define('DIRECT_ACCESS', true);

require_once 'vendor/autoload.php';
require_once 'utils.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');

$twig = new \Twig\Environment($loader, [
    'cache' => 'dist/twig',
    'debug' => true
]);

/**
 * PHP Data Objects
 * @see https://www.php.net/manual/en/book.pdo.php
 */
$pdo = new \PDO(
    "mysql:host=localhost;dbname=diag_shop", // dsn
    'root', // hostname
    'admin' // password
);

// define mysql queries
$queries = [
    "SELECT id, title, discount, price, img FROM products", // 0
    "SELECT id, title, parent_id FROM categories" // 1
];

$template = $twig->load('index.html.twig');
echo $template->render(['products' => executeQuery(0), 'categories' => executeQuery(1)]);
