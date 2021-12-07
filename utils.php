<?php

defined('DIRECT_ACCESS') or exit;

function executeQuery(int $query_id): ?array
{
    // get variable from global to local scope
    global $queries, $pdo;

    $stmt = $pdo->prepare($queries[$query_id]); // create statement from mysql query
    $stmt->execute(); // statement can be executed multiple times ..n
    
    /**
     * fetch statement result as associative array ['key' => 'value']
     * @see: https://www.w3schools.com/Php/php_arrays_associative.asp
     */
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
