<?php

$this->title = 'Users | Admin Panel';
?>

<section id="section" class="products-list">
    <div class="header-left">
        <h1>Users</h1>
    </div>
    <div class="table-container">
        <table class="section-table">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>

            <?php foreach ($users as $user) : ?>
                <tr>

                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['created_at'] ?></td>
                    <td><?= $user['updated_at'] ?></td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>

</section>