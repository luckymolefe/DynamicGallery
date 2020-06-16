<?php

//function to rename a file/directory => rename(oldname, newname)
//function to create a directory => mkdir(pathname)
//function to remove an empty directory => rmdir(pathname)
//function to delete a file => unlink(filename)
//function to open, read and close directory => opendir(), readdir(), closedir()
//function to scan directory for any file => scandir();
//checking if file or direcotry exist validating => is_dir(), file_exists(),

define('FILE_PATH', DIRECTORY_SEPARATOR."houses_gallery".DIRECTORY_SEPARATOR); //define a fixed path;
$filepath = "houses_gallery";

if(isset($_GET['refresh'])) {
?>
	<script type="text/javascript">
		window.open("<?php echo $_SERVER['PHP_SELF']; ?>","_self");
	</script>
<?php
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dynamic Albums</title>
		<link rel="stylesheet" type="text/css" href="houses_gallery/styles.css">
		<script type="text/javascript" src="houses_gallery/ajax_process.js"></script>
	</head>
	<body>
		<div id="layer"></div>
		<div class="container">
			<form action="" method="" enctype="">
			  <h4 class="header">Photo Albums Gallery</h4>
			  <div id="menu"></div>
				<div id="content">
					<p>
						<label class="form-label">Directory list:</label>
						<select id="album" name="currentDir" class="text-controls"></select>
					    
				    </p>
					<p><label class="form-label">Directory name:</label><input type="text" name="newfolder" class="text-controls" placeholder="Type folder name"></p>
					<p>
						<button type="button" class="btn" name="create" value="true" onClick="javascript:ajax_create(document.forms[0].newfolder.value)">Create Directory</button>
						<button type="button" class="btn" name="rename" value="true" onClick="javascript:ajax_rename(document.forms[0].currentDir.value, document.forms[0].newfolder.value)">Rename Directory</button>
						<button type="button" class="btn" name="remove" value="true" onClick="javascript:ajax_remove(document.forms[0].currentDir.value)">Remove Directory</button>
					</p>
					<p>
					  <button type="submit" class="btn" name="refresh" >Refresh Page</button>&nbsp;
					  <button class="btn" type="reset">Clear</button>
					  <button type="button" name="upload" class="btn" onClick="ajax_loadform()">Upload &#10548;</button>
					</p>
				</div> <!-- content END -->
			</form>
		</div><!-- container END -->
		<div id="results"></div>
	</body>
</html>