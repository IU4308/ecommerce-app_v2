<?php

class m0002_create_products
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS products (
                id int(10) unsigned NOT NULL AUTO_INCREMENT,
                title varchar(50) NOT NULL,
                price decimal(10,2) NOT NULL,
                filename varchar(25) NOT NULL,
                created_at timestamp NOT NULL DEFAULT current_timestamp(),
                updated_at datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id)
                ) ENGINE=InnoDB";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "DROP TABLE users";
        $db->pdo->exec($SQL);
    }
}
