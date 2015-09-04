<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="login-page">
    <h1>This is SendaShare</h1>

    <?php if (Session::userIsLoggedIn()) { ?>
        <a type="button" href="<?php echo Config::get('URL'); ?>/login/logout" class="btn btn-danger">Logout</a>
    <? } else { ?>
        <p>Login to be more secure than your friends ;)</p>
        <a type="button" href="<?php echo Config::get('URL'); ?>/login" class="btn btn-danger">Login</a>
    <? } ?>
</div>