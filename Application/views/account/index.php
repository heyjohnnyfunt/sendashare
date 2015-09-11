<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="container">
    <h2>Successfully logged in!</h2>
    <?php if (Session::userIsLoggedIn()) { ?>
        <a type="button" href="<?php echo Config::get('URL'); ?>/login/logout" class="btn btn-danger">Logout</a>
    <? } else { ?>
        <a type="button" href="<?php echo Config::get('URL'); ?>/login" class="btn btn-danger">Login</a>
    <? } ?>
</div>