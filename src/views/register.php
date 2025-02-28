<?php
// /** @var $model \app\models\User */

$this->title = 'Sign Up';

?>


<section id="" class="sign">
    <?php $form = \app\core\form\Form::begin('', 'post', 'sign-form') ?>
    <h1>Sign Up</h1>
    <?php echo $form->field($model, 'username'); ?>
    <?php echo $form->field($model, 'email')->emailField(); ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>

    <button type="submit">Register</button>

    <footer>Already have an account? <a href="/login">Login here</a></footer>
    <?php \app\core\form\Form::end() ?>
</section>