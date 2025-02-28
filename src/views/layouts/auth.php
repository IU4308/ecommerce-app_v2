<?php

use app\core\Application;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="/../src/css/styles.css"> -->
    <title><?= $this->title ?></title>
    <style>
        <?php include Application::$ROOT_DIR . '/src/css/styles.css';
        ?>
    </style>
</head>

<body>
    <main>
        {(content)}
    </main>
</body>

</html>