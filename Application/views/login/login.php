<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 31.08.2015
 * Time: 22:06
 */?>
<div class="login-container">
    <div class="login-page">
        <h1>SendaShare</h1>
        <form action="<?php echo Config::get('URL'); ?>/login/login" method="post">
            <div class="form-group">
                <!--                <label for="username" class="lg-label">Username: </label>-->
                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <!--                <label for="password" class="lg-label">Password: </label>-->
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <?php if (!empty($this->redirect)) { ?>
                <input type="hidden" name="redirect" value="<?php echo $this->redirect ?>" />
            <?php } ?>
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me">Remember me</label>

            <button type="submit" class="btn btn-danger pull-right">Login</button>
        </form>
    </div>
</div>
