<?php require_once Config::get('VIEWS_PATH') . 'account/templates/header.php'; ?>

<?php if (!empty($this->error_message)) { ?>
    <p class="error"><?= $this->error_message ?><br/>
        Please, <a type="button" href="<?php echo Config::get('URL'); ?>/login/logout"
                   class="btn btn-danger">Logout</a>
    </p>
<?php } ?>

    <table class="table-striped">
        <tbody>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Link</th>
            <th>Date created</th>
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
<?php require_once Config::get('VIEWS_PATH') . 'account/templates/footer.php'; ?>