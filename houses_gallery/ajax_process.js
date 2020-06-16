//Functions to communicate with the server side
function ajax_retrive_albums(params) {
	var xhr; //prepare variable to assign object data
	//create ajax XMLHttpRequest object,to be able to use its methods/functions
	var data = "albums=true&path="+params;
	document.getElementById('menu').innerHTML = "<center><p>Please wait...</p></center>";
	xhr = new XMLHttpRequest();
	//open to prepapre connection to a webserver for syncronizing data
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	//Set content-type header information for sending url encoded variable in the request
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//Access the onreadystatechange event for the XMLHttpRequest object
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('menu').innerHTML = xhr.responseText;
		}
	}
	//now send HTTP request data to PHP and wait for server response
	xhr.send(data);
}
var path = "houses_gallery";
setInterval(function() {ajax_retrive_albums(path) }, 1500); //call the function to display MENU Albums 

//this function is fired when you click the albums links
function getPhotos(folder) {
	var pictureframe = document.getElementById("results");
	pictureframe.innerHTML = "<center><p><span><img src='loader_gifs/gears.gif' width='150px'></span><br/>Please wait...</p></center>";

	var data = folder; //long string is combined when passing this parameter

	var hr = new XMLHttpRequest();
    hr.open("POST", "houses_gallery/gallerydata.php", true); /*houses_gallery/gallerydata.php*/
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
	    	pictureframe.innerHTML = hr.responseText;
	    }
    }
    hr.send(data);
}

function ajax_create(params) {
	var xhr; //prepare variable to assign object data
	//create ajax XMLHttpRequest object,to be able to use its methods/functions
	var data = "create=true&newfolder="+params;
	xhr = new XMLHttpRequest();
	//open to prepapre connection to a webserver for syncronizing data
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	//Set content-type header information for sending url encoded variable in the request
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//Access the onreadystatechange event for the XMLHttpRequest object
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('results').innerHTML = xhr.responseText;
			document.forms[0].newfolder.value = '';
		}
	}
	//now send HTTP request data to PHP and wait for server response
	xhr.send(data);
}

function ajax_rename(oldname, newname) {
	var xhr; //prepare variable to assign object data
	//create ajax XMLHttpRequest object,to be able to use its methods/functions
	var data = "rename=true&currentDir="+oldname+"&newfolder="+newname;
	xhr = new XMLHttpRequest();
	//open to prepapre connection to a webserver for syncronizing data
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	//Set content-type header information for sending url encoded variable in the request
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//Access the onreadystatechange event for the XMLHttpRequest object
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('results').innerHTML = xhr.responseText;
			document.forms[0].newfolder.value = '';
		}
	}
	//now send HTTP request data to PHP and wait for server response
	xhr.send(data);
}

function ajax_remove(params) {
	var send = confirm("Continue to send form?"); //confirms submission with message, IF user clicks OK it continues Else Cancel it doesnt continue
	if(send==false) {
		return false;
	} 
	var xhr; //prepare variable to assign object data
	//create ajax XMLHttpRequest object,to be able to use its methods/functions
	var data = "remove=true&currentDir="+params;
	xhr = new XMLHttpRequest();
	//open to prepapre connection to a webserver for syncronizing data
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	//Set content-type header information for sending url encoded variable in the request
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//Access the onreadystatechange event for the XMLHttpRequest object
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('results').innerHTML = xhr.responseText;
		}
	}
	//now send HTTP request data to PHP and wait for server response
	xhr.send(data);
}

function ajax_populate() {
	var xhr; //prepare variable to assign object data
	//create ajax XMLHttpRequest object,to be able to use its methods/functions
	var data = "populate=true";
	xhr = new XMLHttpRequest();
	//open to prepapre connection to a webserver for syncronizing data
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	//Set content-type header information for sending url encoded variable in the request
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//Access the onreadystatechange event for the XMLHttpRequest object
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('album').innerHTML = xhr.responseText;
		}
	}
	//now send HTTP request data to PHP and wait for server response
	xhr.send(data);
}
setInterval(function() {ajax_populate()}, 10000); //call the function

function ajax_loadform() {
	var content = document.getElementById('content');
	content.innerHTML = "<center><p><span><img src='loading.gif' width='50px'></span><br/>Loading...</p></center>";
	var xhr;
	xhr = new XMLHttpRequest();
	xhr.open("POST", "houses_gallery/upload.php", true);
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			content.innerHTML = xhr.responseText;
		}
	}
	xhr.send(null);
}

function uploadFile(filename, folder) {
	var file = document.getElementById("files").files[0];
	var dirname = document.getElementById('album').value;
	// alert(file.name+" | "+file.size+" | "+file.type);

	var formdata = new FormData();
	formdata.append("upload", "true"); //prepare the http server request set a value to accept the request
	formdata.append("media", file); //the name of the file uploaded
	formdata.append("currentDir", dirname); //the name album folder selected

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "houses_gallery/gallerydata.php");
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			document.getElementById('results').innerHTML = xhr.responseText;
			document.getElementById("files").value = '';
		}
		if(xhr.status == 404) {
			document.getElementById('results').innerHTML = "<p class='err_message'><strong>Error 404</strong> The requested URL was not found on this server.</p>"
		}
	}
	xhr.send(formdata);
}

function showImage(folder, path, photo, filename) {
	var displayImg = "<div><img src='"+folder+"/"+path+"/"+photo
	+"' style='width: 950px; height: 650px; margin: 20px 0px 0px 265px; border-radius: 5px; box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.6);' alt='"+photo+"' ><span class='img_name'>"+filename+"</span><a href='javascript:void(0)' title='close' onclick='closeImg()' class='close'>&times;</a></div>";	//"+folder+"  "+path+"  "+photo+"
	document.getElementById('layer').style.visibility = "visible";
	document.getElementById('layer').innerHTML = displayImg; //'Hello testing here';
	//<img src='"+folder+"/"+path+"/"+photo+"' style='max-width: 950px; height: 650px; margin: 20px 0px 0px 250px; border-radius: 5px; box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.6);' alt='"+photo+"' >
}

function closeImg() {
	document.getElementById('layer').innerHTML = '';
	document.getElementById('layer').style.visibility = 'hidden';
}

function deleteImg(path, photo) {
	var remove = confirm("Are you sure you want to delete this photo?.");
	if(remove == false) {
		return false;
	}
	var data = "delete=true&path="+path+"&image="+photo;
	var results = document.getElementById('results');
	results.innerHTML = "<center><p><span><img src='loading.gif' width='50px'></span><br/>Deleting photo, please Wait...</p></center>";

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "houses_gallery/gallerydata.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			results.innerHTML = '';
			results.innerHTML = xhr.responseText;
		}
		if(xhr.status == 404) {
			results.innerHTML = "<p class='err_message'><strong>Error 404</strong> The requested URL was not found on this server.</p>";
		}
	}
	xhr.send(data);
}