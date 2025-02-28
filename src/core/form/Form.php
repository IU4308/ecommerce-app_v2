<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    public const ENCTYPE_DEFAULT = "application/x-www-form-urlencoded";
    public const ENCTYPE_FILE = "multipart/form-data";

    public static function begin($action, $method, $className, $enctype = self::ENCTYPE_DEFAULT)
    {
        echo sprintf('<form enctype="multipart/form-data" action="%s" method="%s" class="%s"  >', $action, $method, $className, $enctype);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}
