<?php
/*streaming photos in the file*/

if(isset($_POST['foldername'])) { //get photos
	$foldername = trim($_POST['foldername']);
	$folderpath = trim($_POST['folderpath']);
	$file_path = "\\".$foldername."\\";
	$path = __DIR__.$file_path; /*$path = getcwd().$file_path;*/
	$files = scandir($path);
	$num_files = glob($path . "*.{JPG,jpg,GIF,gif,PNG,png,bmp}", GLOB_BRACE);//read all images file extensions

	$count = count($num_files); //count the total number of files in the folder

	if($count > 0) {
		echo "<p>Photo's in ".stripslashes($file_path)."  album (".$count.")</p>";
		foreach ($files as $item) {
		    $item_path = $path . DIRECTORY_SEPARATOR . $item;
		    if(is_file($item_path)) { //you can use is_dir or is_file or file_exists
		    	if($item != "." && $item != "..") { //we removing the . and .. navigations
		    		$extension = strtolower(pathinfo($item ,PATHINFO_EXTENSION)); //get file extension
		    		 $parts = pathinfo($item); //extract file information, now get name without extension $parts['filename'];
		    		 
		    	?>
		      	  <a href="javascript:void(0)" class="images" onClick="showImage('<?php echo $folderpath ?>', '<?php echo stripslashes($file_path); ?>', '<?php echo $item; ?>','<?php echo $parts['filename']; ?>')">
		      	  <img src="<?php echo $folderpath.'/'.stripslashes($file_path).'/'.$item; ?>" width="250px" height="200" alt="<?php echo $item; ?>"></a>
		      	  <a href="javascript:void(0)" class="delete-link" onClick="deleteImg('<?php echo stripslashes($file_path); ?>', '<?php echo $item; ?>')">delete</a>
		      	<?php
		  		}	
		    }
		}
	}
	else {
		echo "<p class='err_message'>This <strong>".stripslashes($file_path)."</strong> folder is empty.</p>";
	}
}

if(isset($_POST['create']) && isset($_POST['newfolder'])) { //create new album folder
	if(!empty($_POST['newfolder'])) {
		if(!is_dir($_POST['newfolder'])) {
			if(mkdir($_POST['newfolder'])) {
				echo "<p class='success'>The directory was created successfully!...</p>";
			} else {
				echo "<p class='err_message'>Failed to create new directory, please try again</p>";
			}
		}
		else {
			echo "<p class='err_message'>Sorry the directory with the same name already exist</p>";
		}
	}
	else {
		echo "<p class='err_message'>Please type the name of your new directory.</p>";
	}
}

if(isset($_POST['rename']) && isset($_POST['newfolder']) && isset($_POST['currentDir'])) { //rename an album existing/new one
	$oldname = $_POST['currentDir'];
	$newname = trim(stripslashes($_POST['newfolder']));
	if($oldname != '' && $newname != '') {
		if(rename($oldname, $newname)) {
			echo "<p class='success'>Folder renamed successfully!...</p>";
		} 
		else {
			echo "<p class='err_message'>Failed to rename the specified folder.</p>";
		}
	} 
	else {
		echo "<p class='err_message'>Please type the new name of the folder to rename</p>";
	}
}

if(isset($_POST['remove']) && isset($_POST['currentDir'])) { //remove an empty album
	if(!empty($_POST['currentDir'])) {
		if(is_dir($_POST['currentDir'])) {
			if(rmdir($_POST['currentDir'])) {
				echo "<p class='success'>Direcotry was removed successfully!...</p>";
			} else {
				echo "<p class='err_message'>Failed to delete directory, because its not empty.</p>";
			}
		} else {
			echo "<p class='err_message'>The directory you want to remove does not exist!.</p>";
		}
	} else {
		echo "<p class='err_message'>Please select from a dropdown list which folder you want to remove.</p>";
	}
}

if(isset($_POST['albums']) && isset($_POST['path'])) {  //get list of available folder albums
	function countItems($folder_path) {
		$num_files = glob($folder_path . "*.{JPG,jpg,GIF,gif,PNG,png,bmp}", GLOB_BRACE);
		$count = count($num_files);
		return $count;
	}

	$file_path = DIRECTORY_SEPARATOR.trim(stripslashes($_POST['path'])).DIRECTORY_SEPARATOR;
	$current_path = __DIR__;
/*	$dir_name = (isset($_GET['newfolder'])) ? trim(stripslashes(strip_tags($_GET['newfolder']))) : '';
	$cur_dir = (isset($_GET['currentDir'])) ? trim($_GET['currentDir']) : '';
	$existing_folder = $current_path.$file_path.$cur_dir;
	$fullpath = $current_path.$file_path.$dir_name;*/

	/*creating dropdown Menu album list*/
	$path = getcwd();
	$files = scandir($path);
	echo "<h4 class='menu-header'>Albums Menu</h4>";
    foreach ($files as $item) {
        $item_path = $path . DIRECTORY_SEPARATOR . $item;
        if(is_dir($item_path)) { //you can use is_dir or is_file or file_exists
        	if($item != "." && $item != "..") { //we removing the . and .. navigations
        		$folderpath = stripslashes($file_path); //str_replace("\\", '', $file_path);
        	?>
          	  <a href="javascript:void(0);" onclick="getPhotos('foldername=<?php echo $item; ?>&amp;folderpath=<?php echo $folderpath; ?>');"><?php echo $item; ?></a>
          	<?php
          	  echo " (".countItems($path.DIRECTORY_SEPARATOR.$item."\\").")<br>";
      		}
        }
    }
}

if(isset($_POST['populate'])) {  //fill a dropdown list with names of available album folders
	/*creating dropdown list of available folders*/
	$path = getcwd();
	$files = scandir($path);
?>
	<option value="">Select folder</option>
<?php
    foreach ($files as $item) {
        $item_path = $path . DIRECTORY_SEPARATOR . $item;
        if(is_dir($item_path)) { //you can use is_dir or is_file or file_exists
        	if($item != "." && $item != "..") { //we removing the . and .. navigations
        	?>
          	  <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
          	<?php
      		}
        }
    }
}

/*process image file uploading*/
if(isset($_POST['upload'])) {
    $dir = $_POST['currentDir'];
    if(!empty($dir)) {
        if(!empty($_FILES['media']['name'])) {
            //define file path put the file where we'd like it
            $upfile = $dir."/".$_FILES['media']['name'];

            if(is_uploaded_file($_FILES['media']['tmp_name'])) {
                echo "<p class='success'>Media file was uploaded successfully...</p>"; 
            }

            if (!move_uploaded_file($_FILES['media']['tmp_name'], $upfile)) {
                echo "<p class='err_message'>Sorry could not upload file to destination directory.</p>";
                exit;
            }
        } else {
            echo "<p class='err_message'>Please select an image to upload.</p>";
        }
    } else {
        echo "<p class='err_message'>Please select an Album folder.</p>";
    }
}

//deleting chosen image from a folder
if(isset($_POST['delete'])) {
	$file_path = $_POST['path'];
	$imgObj = $_POST['image'];
	$fullpath = $file_path."/".$imgObj;
	#echo "<p class='err_message'>We received your delete request, to delete ".$imgObj." in ".$file_path."</p>"; //.$file_path."/".$imgObj;

	if(is_file($fullpath)) {
		if(unlink($fullpath)) {
			echo "<p class='success'>Media file deleted successfully...</p>"; 
		} 
		else {
			echo "<p class='err_message'>Failed to deleted the image. please try again.</p>";
		}
	} 
	else {
		echo "<p class='err_message'>Sorry the requested image file does not exist.</p>";
	}
}


?>