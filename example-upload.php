<?php
	// require the FileUploader file
	require_once 'FileUploader.php';
	
	// initilization
	$file = $_FILES['fileInput'];
	$uploader = new FileUploader($file);

	$uploader->upload();
?>