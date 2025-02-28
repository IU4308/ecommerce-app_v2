<?php

namespace app\core;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract static public function tableName(): string;

    abstract public function attributes(): array;

    abstract static public function primaryKey(): string;

    public function save()
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);

            $attributes_str = implode(',', $attributes);
            $params_str = implode(',', $params);

            $statement = self::prepare("INSERT INTO $tableName ($attributes_str) VALUES ($params_str)");

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $statement->execute();
            return true;
        } catch (\PDOException $e) {
            Application::catchPDOExc($e);
            exit;
        }
    }

    public static function findOne($where)
    {
        try {
            $tableName = static::tableName();
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }

            $statement->execute();
            return $statement->fetchObject(static::class);
        } catch (\PDOException $e) {
            Application::catchPDOExc($e);
            return;
        }
    }

    public static function findAll($order_by = 'created_at', $sort = 'DESC')
    {
        try {
            $tableName = static::tableName();
            $statement = self::prepare("SELECT * FROM $tableName ORDER BY $order_by $sort");
            $statement->execute();
            return $statement->fetchAll();
        } catch (\PDOException $e) {
            Application::catchPDOExc($e);
            return;
        }
    }

    public static function deleteOne($where)
    {
        try {
            $tableName = static::tableName();
            $attributes = array_keys($where);
            $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("DELETE FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();

            return true;
        } catch (\PDOException $e) {
            Application::catchPDOExc($e);
            return;
        }
    }

    public static function countAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT COUNT(*) FROM $tableName");
        $statement->execute();
        $count_data = $statement->fetch(\PDO::FETCH_ASSOC);
        return $count_data['COUNT(*)'];
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
