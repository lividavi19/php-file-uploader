<?php
	/*
		Livingstone
		+255 687 949 808
	*/
	function upload ($file = NULL, $uploadFolder = NULL) : string {

		// Handle for empty, non-submitted files
		if ($file == NULL) {
			// Client did not submit a file
			// echo "File can not be empty!";
			return "";
		}

		// Hndle for file-related errors
		if ($file["error"]) {
			// $file["error"] may produce below fatal-type-error
			// Fatal error: Uncaught TypeError: Cannot access offset of type string on string
			// To handle above issue, ensure that the $file is of type array since it should come from $_FILES (array) superglobal
			// echo "File errors detected!";
			return "";
		}

		// Get the file name
		// Trim these characters [DOT, backslash, and forward slash] from a file name
		$fileName = trim($file["name"], "./\\");

		// Extract file extension from file name
		$fileExtension = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION));

		// Define list of allowed file extensions.
		// You can modify this list by add more extensions or remove existing extensions.
		// TODO : Make $EXTENSIONS_ALLOWED variable a constant?
		$EXTENSIONS_ALLOWED = ["PNG", "JPG", "JPEG", "PDF", "MP3", "MP4"];

		// Check if file estension is not allowed
		if (!in_array($fileExtension, $EXTENSIONS_ALLOWED, false)) {
			// echo "{$fileExtension} files not allowed!";
			return "";
		}

		// Get file size (Given in Bytes)
		$fileSize = $file["size"];

		// Set maximum file size allowed for upload for single file
		// The number 2 in this case, means 2MB.
		// You can change this value to fit your needs for a max-size allowed (in MBs).
		// TODO : Make $MAX_SIZE_ALLOWED variable a constant?
		$MAX_SIZE_ALLOWED = 2 * (1024 * 1024);

		// Handle for larger file size
		if ($fileSize > $MAX_SIZE_ALLOWED) {
			// echo "File too big, try a smaller sized-file!";
			return "";
		}

		// In cases when name for $uploadFolder not specified
		// Attempt moving the $file to the current-working-directory
		if ($uploadFolder == NULL) {
			// Attempt to get the current-working-directory
			$uploadFolder = getcwd();

			// getcwd() may return FALSE on failure
			// Handle if could not get the current-working-directory
			if (!$uploadFolder) {
				// echo "Could not get the current working directory!";
				return "";
			}

			// If file name exists assign a random name for file
			$fileName = file_exists("{$uploadFolder}/{$fileName}") ? str_shuffle(md5(microtime().time())).".{$fileExtension}" : $fileName;

			// Attempt to move the file into the current-working-directory
			if (move_uploaded_file($file["tmp_name"], "{$uploadFolder}/{$fileName}")) {
				// echo "File upload success [Current working directory]";
				return "{$fileName}";
			} else {
				// echo "File upload failed [Current working directory]";
				return "";
			}
		}

		// Trim these characters [DOT, backslash, and forward slash] from a folder name
		$uploadFolder = trim($uploadFolder, "./\\");

		// Following characters hold special meaning in Windows and Linux OS
		// ["?", ":", "\"", "<", ">", "|", "*", "/", "\", "."]
		// Characters [".", "/", "\\"] already trimmed above
		// A folder name CAN NOT CONTAIN any of the below characters
		$ILLEGAL_CHARACTERS = ["?", ":", "\"", "<", ">", "|", "*"];
		
		for ($i = 0; $i < strlen($uploadFolder); $i++) {
			if (in_array($uploadFolder[$i], $ILLEGAL_CHARACTERS)) {
				// echo "Folder name CAN NOT CONTAIN <b>{$uploadFolder[$i]}</b> character";
				return "";
			}
		}

		// Handle if specified $uploadFolder dont exists
		if (!is_dir($uploadFolder)) {
			if (!mkdir($uploadFolder, 0511, true)) {
				// mkdir() function above may produce a "folder-not-found" warning
				// echo "Failed to create folder {$uploadFolder}!";
				return "";
			}
		}

		// // If file name exists assign a random name for file
		$fileName = file_exists("{$uploadFolder}/{$fileName}") ? str_shuffle(md5(microtime().time())).".{$fileExtension}" : $fileName;

		// Attempt to upload the $fileName to $uploadFolder
		if (move_uploaded_file($file["tmp_name"], "{$uploadFolder}/{$fileName}")) {
			// echo "File upload success [Specified folder]";
			return "{$fileName}";
		} else {
			// echo "File upload failed [Specified folder]";
			return "";
		}
	}
?>