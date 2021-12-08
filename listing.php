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
    '' // password
);

// get id from url query /?id=[number]
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
    'options' => [
        'default' => 1
    ]
]);

// define mysql queries
$queries = [
    "SELECT p.* FROM categories_products cp INNER JOIN categories c ON c.id = cp.category_id INNER JOIN products p ON p.id = cp.product_id WHERE c.id = :id", // 0
    "SELECT id, title, parent_id FROM categories", // 1
    "SELECT title FROM categories WHERE id = :id", // 2
];

// get category related products
$stmt = $pdo->prepare($queries[0]); // create statement from mysql query
$stmt->bindParam(':id', $id, PDO::PARAM_INT); // bind :id to id from above
$stmt->execute(); // execute statement to get results after
$products = $stmt->fetchAll(\PDO::FETCH_ASSOC); // return statement result as assoc array

// get current category data
$stmt = $pdo->prepare($queries[2]); // create statement from mysql query
$stmt->bindParam(':id', $id, PDO::PARAM_INT); // bind :id to id from above
$stmt->execute(); // execute statement to get results after
$category = $stmt->fetch(\PDO::FETCH_OBJ); // return statement result as object

$template = $twig->load('listing.html.twig');
echo $template->render([
    'products' => $products,
    'categories' => executeQuery(1),
    'category' => $category
]);
