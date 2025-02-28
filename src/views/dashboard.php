<?php

use app\core\Log;



$this->title = 'Admin Panel';
?>

<section id="section" class="dashboard">
    <header>
        <h1>Dashboard</h1>
    </header>

    <div class="cards-container">
        <div class="card">
            <h2>
                Products
            </h2>
            <div><?= $products_count ?></div>
            <a href="products/new">
                <button>Add</button>
            </a>
        </div>
        <div class="card">
            <h2>
                Users Registered
            </h2>
            <div><?= $users_count ?></div>
        </div>
    </div>

    <h2>Recent activity</h2>
    <div class="logs">
        <table>
            <tr>
                <th>Timestamp</th>
                <th>Message</th>
            </tr>

            <?php foreach ($logs as $log) {
                if ($log !== "") {
                    $log = new Log(message: $log, mode: 'r');
                }
            ?>
                <tr>

                    <td class="timestamp">
                        <?= $log->timestamp ?>
                    </td>
                    <td class="message <?php if ($log->type === 'ERROR') echo 'error' ?>">
                        <?= $log->message ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>