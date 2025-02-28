<?php

use app\core\form\Form;

$this->title = 'Sign In';


?>

<section id="" class="sign">
    <?php $form = Form::begin('', 'post', 'sign-form') ?>
    <h1>Sign In</h1>
    <?php echo $form->field($model, 'username'); ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>

    <button type="submit">Login</button>

    <footer>Don't have an account? <a href="/register">Register here</a></footer>
    <?php Form::end() ?>
</section>