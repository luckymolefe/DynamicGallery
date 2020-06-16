<h4 class="menu-header">Upload Photo</h4>
<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <div>
        <p>
            <label class="form-label">Select album to upload photo:</label>
            <select name="currentDir" id="album" class="text-controls"></select>
        </p>
        <p>
            <label class="form-label">Select image to upload</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input type="file" class="text-controls" name="media" id="files">
        </p>
    </div>
    <div>
        <hr>
        <a href="dynamicphotoalbum.php" class="btn-link">&larr; Back</a>
        <button type="reset" class="btn btn-default" onclick="return confirm('Want to reset form?');">Clear</button> 
        <button type="button" class="btn btn-success" name="upload" onClick="uploadFile()">Upload <span class="fa fa-upload">&#10555;</span></button>
    </div>
</form>
