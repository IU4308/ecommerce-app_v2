<?php

/** @var $exception \Exception */

?>
<div class="error-page">
    <h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>

</div>