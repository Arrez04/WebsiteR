<?php

header("Content-Type: application/json; charset=UTF-8");

include "Routes/ProductRoutes.php";

use app\Routes\ProductRoutes;

// Menangkap request method
$method = $_SERVER['REQUEST_METHOD'];

// Menangkap request path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Panggil routes
$productRoutes = new Routes\ProductRoutes();
$productRoutes->handle($method, $path);