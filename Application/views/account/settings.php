<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 09.09.2015
 * Time: 19:18
 */ ?>

<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="container">
    <h2>Settings</h2>

    <noscript>
        <p class="error">ATENSION! This page won't work properly without enabled JavaScript. Your password will be
            transfered to server unencrypted. Please, check how to enable it
            in your browser and reload the page.</p>
    </noscript>

    <div class="settings" id="settings">
        <fieldset>
            <legend>General</legend>

            <?php if (!empty($this->error_message)) { ?>
                <p class="error"><?= $this->error_message ?><br/>
                    Please, <a type="button" href="<?php echo Config::get('URL'); ?>/login/logout"
                               class="btn btn-danger">Logout</a>
                </p>
            <?php } ?>

            <div class="form-group">
                <label for="username" class="lg-label col-sm-3">Username: </label>
                <input type="text" name="username" id="username" class="form-control col-sm-9"
                       placeholder="Username (2-32 chars)" pattern="^([a-zA-Z0-9]{2,32})$" required
                       value="<? if (!empty($this->username)) echo $this->username ?>">
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif"
                     id="loaderIcon"/>
            </div>

            <div class="form-group">
                <label for="email" class="lg-label col-sm-3">Email: </label>
                <input type="email" name="email" id="email" class="form-control col-sm-9"
                       placeholder="Email (2-32 chars)" required
                       value="<? if (!empty($this->email)) echo $this->email ?>">
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif"
                     id="loaderIcon"/>
            </div>

            <div class="form-group">
                <label for="firstname" class="lg-label col-sm-3">First name: </label>
                <input type="text" name="firstname" id="firstname" class="form-control col-sm-9"
                       placeholder="First name" pattern="^([-a-zA-Z]{2,64})$"
                       value="<? if (!empty($this->firstname)) echo $this->firstname ?>">
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif"
                     id="loaderIcon"/>
            </div>

            <div class="form-group">
                <label for="lastname" class="lg-label col-sm-3">Last name: </label>
                <input type="text" name="lastname" id="lastname" class="form-control col-sm-9"
                       placeholder="Last name" pattern="^([-a-zA-Z]{2,64})$"
                       value="<? if (!empty($this->lastname)) echo $this->lastname ?>">
                <img class="form-loader-icon" src="<?php echo Config::get('URL'); ?>/img/ajax-loader.gif"
                     id="loaderIcon"/>
            </div>

        </fieldset>
        <fieldset>
            <legend>Password</legend>
            <form id="changePassword" method="post">
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
                <button class="btn btn-danger pull-right" type="submit">Change password</button>
            </form>
        </fieldset>
    </div>


</div>
