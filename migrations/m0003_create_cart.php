<?php

class m0003_create_cart
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $SQL = "CREATE TABLE IF NOT EXISTS cart (
                id int(11) NOT NULL AUTO_INCREMENT,
                title varchar(50) NOT NULL,
                price decimal(10,2) NOT NULL,
                filename varchar(25) NOT NULL,
                created_at timestamp NOT NULL DEFAULT current_timestamp(),
                user_id int(11) NOT NULL,
                product_id int(10) unsigned NOT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY user_products (user_id,product_id),
                KEY fk_product_id (product_id),
                CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
                CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
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
