<?php

use app\core\Application;

$this->title = 'Home';

?>

<section id="section-home" class="home">
    <?php Application::displayFlashMessage() ?>
    <ul class="products-container">
        <?php foreach ($products as $product) : ?>
            <li class="product">
                <?php if (in_array($product['id'], $selected_ids)) { ?>
                    <button disabled="true" type="submit" class="disabled">✔️</button>
                <?php } else { ?>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="title" value="<?= $product['title'] ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <input type="hidden" name="filename" value="<?= $product['filename'] ?>">
                        <button type="submit" class="add-button">+</button>
                    </form>
                <?php } ?>
                <div class="img-container">
                    <img
                        class="product-img"
                        src="uploads/<?= $product['filename'] ?>"
                        alt="<?= $product['filename'] ?>">
                </div>
                <h2><?= $product['title'] ?></h2>
                <span><?= $product['price'] ?>$</span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>