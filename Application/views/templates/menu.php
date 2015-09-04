<?php
/**
 * Created by PhpStorm.
 * User: skogs
 * Date: 04.09.2015
 * Time: 1:23
 */
?>

<nav class="navbar clearfix">
    <div class="container">
        <div class="logo">
            <a href="<?php echo Config::get('URL'); ?>/">
                <h1>SendaShare</h1>
            </a>
        </div>

        <ul class="nav">
            <li><a href="<?php echo Config::get('URL'); ?>/">Home page</a></li>
            <li><a href="<?php echo Config::get('URL'); ?>/account">Profile</a></li>
            <li><a href="<?php echo Config::get('URL'); ?>/login/logout">Logout</a></li>
        </ul>
    </div>
</nav>
