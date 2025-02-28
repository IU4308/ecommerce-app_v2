<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AdminMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Product;
use app\models\User;
use app\core\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware(['dashboard', 'products', 'users']));
    }

    public function dashboard()
    {
        $products_count = Product::countAll();
        $users_count = User::countAll();
        $logs = Log::read_logs();

        $this->setLayout('admin');
        return $this->render('dashboard', [
            'products_count' => $products_count,
            'users_count' => $users_count,
            'logs' => $logs
        ]);
    }

    public function products()
    {
        $products = Product::findAll();
        $this->setLayout('admin');
        return $this->render('products', [
            'products' => $products
        ]);
    }

    public function users()
    {
        $users = User::findAll();
        $this->setLayout('admin');
        return $this->render('users', [
            'users' => $users
        ]);
    }

    public function new_product(Request $request, Response $response)
    {
        $product = Application::$app->session->getFlash('productForm');
        if (!$product) {
            $product = new Product();
        }


        if ($request->isPost()) {
            $product->loadData($request->getBody($product));
            Application::$app->session->setFlash('product', $product);

            if ($product->validate() && $product->save()) {
                Application::$app->session->setFlash('success', 'The product has been added successfully');
                new Log(Application::$app->user->username . ' Added the product ' . $product->title, 'SUCCESS');
                $response->redirect('/products');
                exit;
            } else {
                Application::$app->session->setFlash('productForm', $product);
                $response->redirect('/products/new');
                return;
            }
        }

        $this->setLayout('admin');
        return $this->render('new_product', [
            'model' => $product
        ]);
    }

    public function delete_product(Request $request, Response $response)
    {
        $id = $_POST['product_id'];
        $title = $_POST['title'];
        $filename = $_POST['filename'];

        if (Product::deleteOne(['id' => $id])) {
            unlink(Application::$ROOT_DIR . '/public/uploads/' . $filename);
            Application::$app->session->setFlash('success', 'The product has been deleted successfully');
            new Log(Application::$app->user->username . ' Deleted the product ' . $title, 'SUCCESS');

            $response->redirect('/products');
        }
    }
}
