<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="content">
    <div class="container clearfix">
        <h2>File management</h2>

        <div class="col-sm-4">
            <ul class="nav-left">
                <li><a href="">Upload new file</a></li>
                <li><a href="">My files</a></li>
                <li><a href="">Bookmarks</a></li>
            </ul>
        </div>
        <div class="col-sm-8">
            <!--<form id="dropZone-form" action="<?php /*echo Config::get('URL'); */?>/account/ajaxUpload" enctype="multipart/form-data" method="post">
                Select image to upload:
                <input type="file" name="fileToUpload[]" id="fileToUpload">
                <input type="submit" value="Upload" name="submit">
            </form>-->

            <b> <b class="error">ATENSION!</b> Max size: 100Mb. Max number of files: 20.</b>
            <form id="dropZone-form" class="upload-file" action="<?php echo Config::get('URL'); ?>/account/ajaxUpload" enctype="multipart/form-data" method="post">
                <div id="dropZone" class="upload-inner">
                    <span>Drag & Drop files here</span>
                </div>
            </form>
            <div id="files"></div>
        </div>
    </div>
</div>