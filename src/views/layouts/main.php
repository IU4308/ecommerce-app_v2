<?php

use app\core\Application;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="/../src/css/styles.css"> -->
    <title><?php echo $this->title ?></title>
    <style>
        <?php include Application::$ROOT_DIR . '/src/css/styles.css';
        ?>
    </style>
</head>

<body>
    <main>
        <header class="home-header">
            <h1>
                <a href="/">Acme</a>
            </h1>
            <ul>
                <?php if (Application::$app->isAdmin()) { ?>
                    <li>
                        <a href="/dashboard">Admin Panel</a>
                    </li>
                <?php }  ?>
                <?php if (Application::$app->isGuest()) { ?>
                    <li>
                        <a href="/login">Sign In</a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="/cart">Cart</a>
                    </li>
                    <li>
                        <a href="/logout"><?php echo Application::$app->user->getDisplayName() ?> (Logout) </a>
                    </li>
                <?php }  ?>
            </ul>
        </header>

        {(content)}
    </main>
</body>

</html>