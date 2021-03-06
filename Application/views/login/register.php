<?php /**
 * Created by PhpStorm.
 * User: skogs
 * Date: 05.09.2015
 * Time: 12:55
 */ ?>
<div class="container">
    <a href="<?php echo Config::get('URL'); ?>/">
        <h1>SendaShare</h1>
    </a>

    <div class="registration">

        <h2>Registration</h2>

        <noscript>
            <p class="error">ATENSION! This page won't work properly without enabled JavaScript. Your password will be
                transfered to server unencrypted. Please, check how to enable it
                in your browser and reload the page.</p>
        </noscript>

        <form id="registration" action="<?php echo Config::get('URL'); ?>/login/register" method="post">
            <div class="form-group">
                <label for="username" class="lg-label col-sm-3">Username: </label>
                <input type="text" name="username" id="username" class="form-control col-sm-9"
                       placeholder="Username (2-32 chars)" pattern="^([a-zA-Z0-9]{2,32})$" required>
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif" id="loaderIcon" />
            </div>
            <p></p>
            <div class="form-group">
                <label for="email" class="lg-label col-sm-3">Email: </label>
                <input type="email" name="email" id="email" class="form-control col-sm-9"
                       placeholder="Email (6-32 chars)" required>
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif" id="loaderIcon" />
            </div>
            <p></p>
            <div class="form-group">
                <label for="firstname" class="lg-label col-sm-3">First name: </label>
                <input type="text" name="firstname" id="firstname" class="form-control col-sm-9"
                       placeholder="First name" pattern="^([-a-zA-Z]{2,64})$">
            </div>
            <div class="form-group">
                <label for="lastname" class="lg-label col-sm-3">Last name: </label>
                <input type="text" name="lastname" id="lastname" class="form-control col-sm-9"
                       placeholder="Last name" pattern="^([-a-zA-Z]{2,64})$">
            </div>
            <div class="form-group">
                <label for="password" class="lg-label col-sm-3">Password: </label>
                <input type="password" name="password" id="password" class="form-control col-sm-9"
                       placeholder="Password" autocomplete="off" pattern="{6,}" required>
            </div>
            <div class="form-group">
                <label for="confPassword" class="lg-label col-sm-3">Confirm password: </label>
                <input type="password" name="confPassword" id="confPassword" class="form-control col-sm-9"
                       placeholder="Repeat password" autocomplete="off" pattern="{6,}" required>
            </div>

<!--            <input type="hidden" name="salt" value="--><?//= Csrf::makeToken();?><!--">-->

            <button type="submit" class="btn btn-danger pull-right">Register</button>
        </form>

        <div class="login-toggle">
            <a href="<?= Config::get('URL'); ?>/login">&larr; Login</a>
        </div>
    </div>
</div>
