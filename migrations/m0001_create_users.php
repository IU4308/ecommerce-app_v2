<?php

class m0001_create_users
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS users (
                id int(11) NOT NULL AUTO_INCREMENT,
                username varchar(25) NOT NULL,
                email varchar(320) NOT NULL,
                password varchar(256) NOT NULL,
                role tinyint(1) NOT NULL DEFAULT 0,
                created_at timestamp NOT NULL DEFAULT current_timestamp(),
                updated_at datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (id),
                UNIQUE KEY username (username),
                UNIQUE KEY email (email)
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
