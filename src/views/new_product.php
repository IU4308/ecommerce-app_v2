<?php

use app\core\File;
use app\core\form\Form;

?>


<section id="section">
    <header class="form-header">
        <h1>
            Add New Product
        </h1>
    </header>

    <?php $form = Form::begin('', 'post', 'add-form') ?>
    <?php echo $form->field($model, 'title'); ?>
    <?php echo $form->field($model, 'price')->numberField(); ?>
    <?php echo $form->field($model, File::FILE_ATTRIBUTE)->fileField(); ?>

    <div class="submit-button">
        <button type="submit">Add</button>
    </div>

    <?php Form::end() ?>

</section>