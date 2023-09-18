<?php
	/*
		Livingstone
		+255 687 949 808
	*/
	function upload ($file = null, $uploadFolder = null) : string {

		// Ensure the file is set (and not null)
		// Ensure the submitted file is not empty
		if (!isset($file) || empty($file)) {
			// File not specified, or empty
			return "";
		}

		// Ensure the file is an array ($_FILES array superglobal)
		if (!is_array($file)) {
			// Not an array
			return "";
		}

		// Ensure $file[error] is present (files uploaded via a form)
		// Ensure $file[error] is false (0 in this case)
		if (!isset($file["error"]) || $file["error"]) {
			// Property "error" not present
			// $file[error] == 1
			// File errors detected
			return "";
		}

		// Ensure the file has a "tmp_name" property
		// Ensure the file at "tmp_name" is indeed a valid-uploaded-file
		// Ensure that the file was uploaded through an HTTP POST request
		if (!isset($file["tmp_name"]) || !is_uploaded_file($file["tmp_name"])) {
			// Not a valid uploaded file
			return "";
		}

		// Get the file name
		// Ensure a file name does not start or end with these characters [DOT, forward-slash and back-slash]
		$fileName = trim($file["name"], "./\\");

		// Extract file extension from file name
		$fileExtension = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION));

		// Define list of allowed file extensions.
		// You can modify this list by add more extensions or remove existing extensions.
		// TODO : Make $EXTENSIONS_ALLOWED variable a constant?
		$EXTENSIONS_ALLOWED = ["PNG", "JPG", "JPEG", "PDF"];

		// Ensure the file estension is allowed
		if (!in_array($fileExtension, $EXTENSIONS_ALLOWED, false)) {
			// File extension not allowed
			return "";
		}

		// Get file size (Given in Bytes)
		$fileSize = $file["size"];

		// Set maximum file size allowed for upload for single file
		// The number 2 in this case, means 2MB.
		// You can change this value to fit your needs for a max-size allowed (in MBs).
		// TODO : Make $MAX_SIZE_ALLOWED variable a constant?
		$MAX_SIZE_ALLOWED = 2 * (1024 * 1024);

		// Ensure the file size is within the maximum-size-allowed
		if ($fileSize > $MAX_SIZE_ALLOWED) {
			// File bigger than the max-allowed-size
			return "";
		}


		// Ensure a folder name does not start or end with these characters [DOT, forward-slash and back-slash]
		$uploadFolder = trim($uploadFolder, "./\\");

		// Ensure a folder name does not contain any of below characters
		// These characters hold special meaning in Windows and Unix platforms
		$UNALLOWED_CHARACTERS = ["?", ":", "\"", "<", ">", "|", "*"];

		for ($i = 0; $i < strlen($uploadFolder); $i++) { 
			if (in_array($uploadFolder[$i], $UNALLOWED_CHARACTERS)) {
				// Folder name contains unallowed {$uploadFolder[$i]} character(s)
				return "";
			}
		}


		// In cases when name for $uploadFolder not specified
		// Attempt moving the $file to the current-working-directory
		if ($uploadFolder == null) {
			// Attempt to get the current-working-directory
			$uploadFolder = getcwd();

			// getcwd() may return FALSE on failure
			// Handle if could not get the current-working-directory
			if (!$uploadFolder) {
				// Could not get the current working directory
				return "";
			}

			// Ensure the filename does not already exist in the upload-folder
			// If so assign a new, random name for the file
			$fileName = file_exists("{$uploadFolder}/{$fileName}") ? str_shuffle(md5(microtime().time())).".{$fileExtension}" : $fileName;

			// Attempt to move the file into the current-working-directory
			if (move_uploaded_file($file["tmp_name"], "{$uploadFolder}/{$fileName}")) {
				// File upload [to the current working directory] success
				return "{$fileName}";
			} else {
				// File upload [to the current working directory] failed
				return "";
			}
		}


		// If a client supplied a name for $uploadFolder
		// Ensure the supplied folder-name does exist, if not create it
		if (!is_dir($uploadFolder)) {
			if (!mkdir($uploadFolder, 0511, true)) {
				// mkdir() function above may produce a "folder-not-found" warning
				// Failed to create the folder
				return "";
			}
		}

		// Ensure the filename does not already exist in the upload-folder
		// If so assign a new, random name for the file
		$fileName = file_exists("{$uploadFolder}/{$fileName}") ? str_shuffle(md5(microtime().time())).".{$fileExtension}" : $fileName;

		// Attempt to upload the $fileName to $uploadFolder
		if (move_uploaded_file($file["tmp_name"], "{$uploadFolder}/{$fileName}")) {
			// File upload [to specified folder]  success
			return "{$fileName}";
		} else {
			// File upload [to specified folder] failed
			return "";
		}
	}
?>