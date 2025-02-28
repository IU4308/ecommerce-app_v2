<?php

use app\controllers\AdminController;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;


$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]

];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->post('/', [AuthController::class, 'add_to_cart']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/cart', [AuthController::class, 'cart']);
$app->router->post('/cart', [AuthController::class, 'delete_from_cart']);
$app->router->get('/dashboard', [AdminController::class, 'dashboard']);
$app->router->get('/products', [AdminController::class, 'products']);
$app->router->post('/products', [AdminController::class, 'delete_product']);
$app->router->get('/users', [AdminController::class, 'users']);
$app->router->get('/products/new', [AdminController::class, 'new_product']);
$app->router->post('/products/new', [AdminController::class, 'new_product']);


$app->run();
