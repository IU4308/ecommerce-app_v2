<?php

namespace app\core;

use app\core\DbModel;

abstract class UserModel extends DbModel
{
    public int $role = 0;
    public string $username = '';

    abstract public function getDisplayName(): string;
}
