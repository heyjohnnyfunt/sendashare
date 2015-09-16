<?php /**
 * Created by PhpStorm.
 * User: skogs
 * Date: 16.09.2015
 * Time: 22:19
 */?>
<?php require_once Config::get('VIEWS_PATH') . 'account/templates/header.php'; ?>

<?php if (!empty($this->error_message)) { ?>
    <p class="error"><?= $this->error_message ?><br/>
        Please, <a type="button" href="<?php echo Config::get('URL'); ?>/login/logout"
                   class="btn btn-danger btn-sm">Logout</a>
    </p>
<?php } ?>

<table class="table-striped">
    <tbody>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Link</th>
        <th>Author</th>
    </tr>
    <? if($this->files) foreach($this->files as $key => $file) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $file["file_name"]?></td>
            <td><input class="form-control" value="<?= $file["file_path"]?>"></td>
            <td><?= $file["date_created"]?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
<form id="addBookmark" action="<?= Config::get('URL'); ?>/account/addBookmark" method="post">
    <input id="link" name="link" type="text" placeholder="Enter SendaShare link" class="form-control">
    <button type="submit" class="btn btn-danger btn-sm pull-right">Add file</button>
</form>
<?php require_once Config::get('VIEWS_PATH') . 'account/templates/footer.php'; ?>
