<?php

namespace app\models;

use app\core\Application;

class CartProduct extends Product
{
    public string $user_id = '';

    public function __construct()
    {
        $this->user_id = Application::$app->session->get('user');
    }

    public static function tableName(): string
    {
        return 'cart';
    }

    public function attributes(): array
    {
        return ['title', 'price', 'filename', 'product_id', 'user_id'];
    }

    public static function findAll($order_by = 'created_at', $sort = 'DESC')
    {
        try {
            $tableName = static::tableName();

            $where = ['user_id' => Application::$app->session->get('user')];
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql ORDER BY $order_by $sort");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();

            return $statement->fetchAll();
        } catch (\PDOException $e) {
            Application::catchPDOExc($e);
            return;
        }
    }
}
