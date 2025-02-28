<?php

namespace app\models;

use app\core\ProductModel;

class Product extends ProductModel
{
    public string $product_id = '';
    public string $title = '';
    public string $price = '';
    // public string $filename = '';
    // public ?File $file = null;

    public static function tableName(): string
    {
        return 'products';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function filters(): array
    {
        return [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => [FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION]
        ];
    }

    public function attributes(): array
    {
        return ['title', 'price', 'filename'];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title',
            'price' => 'Price',
            'filename' => 'Image'
        ];
    }

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], [self::RULE_MIN, 'min' => 5], [self::RULE_MAX, 'max' => 50]],
            'price' => [self::RULE_REQUIRED, [self::RULE_MIN_NUM, 'min_num' => 1], [self::RULE_MAX_NUM, 'max_num' => 10000]]
        ];
    }
}
