<?php /**
 * Created by PhpStorm.
 * User: skogs
 * Date: 12.09.2015
 * Time: 0:13
 */ ?>


<?php require_once Config::get('VIEWS_PATH') . 'account/templates/header.php'; ?>

<b><span class="error">ATENSION!</span> Max size: 100Mb. Max number of files: 20.</b>
<form id="dropZone-form" class="upload-file" action="<?php echo Config::get('URL'); ?>/account/ajaxUpload"
      enctype="multipart/form-data" method="post">
    <div id="dropZone" class="upload-inner">
        <span>Drag & Drop files here</span>
    </div>
</form>
<div id="files"></div>

<?php require_once Config::get('VIEWS_PATH') . 'account/templates/footer.php';?>