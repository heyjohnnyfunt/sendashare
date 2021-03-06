<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:06
 */ ?>
<div class="login-page col-sm-6">
    <a href="<?php echo Config::get('URL'); ?>/">
        <h1>SendaShare</h1>
    </a>


    <noscript>
        <p class="error">ATENSION! This page won't work properly without enabled JavaScript. Your password will be
            transfered to server unencrypted. Please, check how to enable it
            in your browser and reload the page.</p>
    </noscript>

    <form id="login" action="<?= Config::get('URL'); ?>/login/login" method="post">
        <div class="form-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username or E-mail"
                   required>
            <img class="form-loader-icon" src="<?= Config::get('URL'); ?>/img/ajax-loader.gif" id="loaderIcon"/>
        </div>
        <p></p>

        <div class="form-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" pattern="{6,}" required>
        </div>
        <?php if (!empty($this->redirect)) { ?>
            <input type="hidden" name="redirect" value="<?= $this->redirect ?>"/>
        <?php } ?>
        <input type="checkbox" id="remember_me" name="remember_me">
        <label for="remember_me">Remember me</label>
        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken();?>">

        <button type="submit" class="btn btn-danger pull-right">Login</button>
    </form>
    <div class="login-toggle">
        <a href="<?= Config::get('URL'); ?>/login/registration">Registration &rarr;</a>
    </div>
</div>
