<?php

$this->title = 'Cart';
?>


<section id="section-cart" class="cart">
    <div class="header-left">
        <h1>Your Cart</h1>
    </div>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th></th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td class="img-td">
                        <img
                            class="product-img"
                            src="uploads/<?= $product['filename'] ?>"
                            alt="<?= $product['filename'] ?>">
                    </td>
                    <td><?= $product['title'] ?></td>
                    <td><?= $product['price'] ?>$</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <button type="submit" class="action-btn">❌ Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</section>