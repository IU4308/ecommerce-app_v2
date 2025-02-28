<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\CartProduct;
use app\models\Product;

class SiteController extends Controller
{
    public function home()
    {
        $cart_products = null;
        $selected_ids = [];
        $products = Product::findAll();
        if (Application::$app->user) {
            $cart_products = CartProduct::findAll();
            foreach ($cart_products as $product) {
                $selected_ids[] = $product['product_id'];
            }
        }
        return $this->render('home', [
            'products' => $products,
            'cart_products' => $cart_products,
            'selected_ids' => $selected_ids
        ]);
    }
}
