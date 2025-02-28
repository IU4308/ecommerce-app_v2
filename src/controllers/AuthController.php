<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\CartProduct;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['cart']));
    }

    public function login(Request $request, Response $response)
    {

        $loginForm = Application::$app->session->getFlash('loginForm');
        if (!$loginForm) {
            $loginForm = new LoginForm();
        }

        if ($request->isPost()) {
            $loginForm->loadData($request->getBody($loginForm));
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->session->setFlash('success', 'You have successfully logged in');
                $response->redirect('/');

                return;
            } else {
                Application::$app->session->setFlash('loginForm', $loginForm);

                $response->redirect('/login');
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request, Response $response)
    {
        $user = Application::$app->session->getFlash('registerForm');
        if (!$user) {
            $user = new User();
        }

        if ($request->isPost()) {
            $user->loadData($request->getBody($user));

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                $response->redirect('/');
                exit;
            } else {
                Application::$app->session->setFlash('registerForm', $user);
                $response->redirect('/register');
                return;
            }
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function cart()
    {
        $products = CartProduct::findAll();
        return $this->render('cart', [
            'products' => $products
        ]);
    }

    public function add_to_cart(Request $request, Response $response)
    {
        $product = new CartProduct();
        $product->loadData($request->getBody($product));
        if ($product->save()) {
            Application::$app->session->setFlash('success', 'The Product has been added to the cart.');
            $response->redirect('/');
            exit;
        }
    }

    public function delete_from_cart(Request $request, Response $response)
    {
        $id = $_POST['product_id'];

        if (CartProduct::deleteOne(['product_id' => $id])) {
            $response->redirect('/cart');
        }
    }
}
