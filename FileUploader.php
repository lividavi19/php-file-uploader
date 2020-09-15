<?php
	// set the headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	class FileUploader {
		// storage directory path
		private $_pathToFile = 'uploads';

		// file properties
		private $_file;
		private $_fileName;
		private $_fileType;
		private $_tmpDir;
		private $_fileError;
		private $_fileSize;
		private $_fileExtension;

		// allowed extensions
		private $_allowedExtensions = ['png', 'jpg', 'jpeg', 'pdf', 'mp3'];
		private $_maxAllowedFileSize = 2;

		// constructor
		function __construct ($inputFile) {
			$this->_file = $inputFile;
			$this->_fileName = $this->_file['name'];
			$this->_fileType = $this->_file['type'];
			$this->_tmpDir = $this->_file['tmp_name'];
			$this->_fileError = $this->_file['error'];
			$this->_fileSize = $this->_file['size'];
			$this->_fileExtension = strtolower(pathinfo($this->_fileName, PATHINFO_EXTENSION));
		}

		// upload()
		function upload () {
			// check for file errors
			if ($this->_fileError !== 0) {
				// extension not allowed
				$uploadObject = [
					'uploaded' => false,
					'message' => "file error(s)"
				];
				$this->printJSON($uploadObject);
			}

			// check for allowed file extensions
			if (!in_array($this->_fileExtension, $this->_allowedExtensions)) {
				// extension not allowed
				$uploadObject = [
					'uploaded' => false,
					'message' => "type '{$this->_fileExtension}' files not allowed"
				];
				$this->printJSON($uploadObject);
			}

			// check for max-allowed file size
			if ($this->_fileSize > $this->_maxAllowedFileSize*(1024*1024)) {
				// extension not allowed
				$uploadObject = [
					'uploaded' => false,
					'message' => "file size biggr than max-allowed"
				];
				$this->printJSON($uploadObject);
			}

			// handle if file already exists
			if (file_exists("{$this->_pathToFile}/{$this->_fileName}")) {
				// file exists, re-assign file name
				$this->_fileName = str_shuffle(md5(microtime().time())).'.'.$this->_fileExtension;
			}

			// upload a file
			if (move_uploaded_file($this->_tmpDir, "{$this->_pathToFile}/{$this->_fileName}")) {
				// success file upload
				$uploadObject = [
					'uploaded' => true,
					'message' => "success file upload",
					'uploadInfo' => [
						'fileName' => $this->_fileName,
						'fileType' => $this->_fileType,
						'fileSize' => $this->_fileSize
					]
				];
				$this->printJSON($uploadObject);
			} else {
				// internal error(s) uploading a file
				$uploadObject = [
					'uploaded' => false,
					'message' => "error uploading the file"
				];
				$this->printJSON($uploadObject);
			}
		}

		// print file info in json
		private function printJSON ($json) {
			echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
			die();
		}
	}
?>
