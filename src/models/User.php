<?php

namespace app\models;

use app\core\Application;
use app\core\UserModel;

class User extends UserModel
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    public string $username = '';
    public string $email = '';
    public int $role = self::ROLE_USER;
    public string $password = '';
    public string $confirmPassword = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function role()
    {
        return 'role';
    }


    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::save();
        $app = Application::$app;
        $last_id = $app->db->pdo->lastInsertId();
        $app->session->set('user', $last_id);
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], [self::RULE_MIN, 'min' => 3], [self::RULE_MAX, 'max' => 25]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function filters(): array
    {
        return [
            'username' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_SANITIZE_SPECIAL_CHARS,
            'confirmPassword' => FILTER_SANITIZE_SPECIAL_CHARS
        ];
    }

    public function attributes(): array
    {
        return ['username', 'email', 'password'];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->username;
    }
}
