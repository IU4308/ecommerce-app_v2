<?php

use app\core\Application;

$this->title = 'Products | Admin Panel';

?>

<section id="section" class="products-list">
    <div class="header-left">
        <h1>Products</h1>
        <a href="/products/new">
            <button>Add</button>
        </a>
        <?php Application::displayFlashMessage() ?>

    </div>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Added At</th>
                <th class="actions-th">Actions</th>
            </tr>

            <?php foreach ($products as $product) : ?>
                <tr>
                    <td class="img-td">
                        <img
                            class="table-img"
                            src="uploads/<?= $product['filename'] ?>"
                            alt="<?= $product['filename'] ?>">
                    </td>
                    <td><?= $product['title'] ?></td>
                    <td><?= $product['price'] ?>$</td>
                    <td><?= $product['created_at'] ?></td>
                    <td class="actions-td">
                        <ul>
                            <li>
                                <form action="" method="post">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="title" value="<?= $product['title'] ?>">
                                    <input type="hidden" name="filename" value="<?= $product['filename'] ?>">
                                    <button type="submit" class="action-btn">❌ Delete</button>
                                </form>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</section>