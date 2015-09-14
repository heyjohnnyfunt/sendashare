<? include(Config::get('VIEWS_PATH') . 'templates/menu.php') ?>

<div class="content">
    <div class="container clearfix">
        <h2>Profile</h2>

        <div class="col-sm-4">
            <ul class="nav-left">
                <li><a href="">Uploaded new file</a></li>
                <li><a href="">My files</a></li>
                <li><a href="">Bookmarks</a></li>
            </ul>
        </div>
        <div class="col-sm-8">
            <form class="upload-file" action="/account/ajaxUpload">
                <div id="dropZone" class="upload-inner">
                    <span>Drag & Drop files here</span>
                </div>
            </form>
        </div>
    </div>
</div>