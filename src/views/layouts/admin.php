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
        <section class="nav-bar">
            <header>
                <a href="/">
                    <h1>Home</h1>
                </a>
            </header>
            <nav>
                <ul>
                    <a href="/dashboard">
                        <li
                            class="<?php //printClassName("dashboard.php") 
                                    ?>">
                            Dashboard
                        </li>
                    </a>
                    <a href="/products">
                        <li
                            class="<?php //printClassName("products.php") 
                                    ?>">
                            Products
                        </li>
                    </a>
                    <a href="/users">
                        <li
                            class="<?php //printClassName("users.php") 
                                    ?>">
                            Users
                        </li>
                    </a>
                </ul>
            </nav>
        </section>
        {(content)}
    </main>
</body>

</html>