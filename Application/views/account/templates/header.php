<?php /**
 * Created by PhpStorm.
 * User: skogs
 * Date: 15.09.2015
 * Time: 22:58
 */ ?>


<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="content">
    <div class="container clearfix">
        <h2>File management</h2>

        <div class="col-sm-3">
            <ul class="nav-left">
                <li>
                    <a href="<?php echo Config::get('URL'); ?>/account/upload" <? if (AccountController::checkPage('upload')) echo 'class="active"' ?>>Upload
                        new file</a></li>
                <li>
                    <a href="<?php echo Config::get('URL'); ?>/account/files" <? if (AccountController::checkPage('files')) echo 'class="active"' ?>>My
                        files</a></li>
               <!-- <li>
                    <a href="<?php /*echo Config::get('URL'); */?>/account/bookmarks" <?/* if (AccountController::checkPage('bookmarks')) echo 'class="active"' */?>>Bookmarks</a>
                </li>-->
            </ul>
        </div>
        <div class="col-sm-9">
