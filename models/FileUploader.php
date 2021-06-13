<?php
    // headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: '.(!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME']);

    // require loaders
    require_once $_SERVER['DOCUMENT_ROOT'].'/devi/php-file-uploader/autoloaders/load_helpers.php';

    class FileUploader {
        private $file;
        private $file_name;
        private $file_type;
        private $file_tmp_name;
        private $file_error;
        private $file_size;
        
        private $file_extension;
        private $path_to_folder;
        private $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif', 'pdf', 'mp3', 'mp4'];
        private $max_size_allowed = 2*(1024*1024); // 2 in MBs

        // constructor
        function __construct ($file = null) {
            $this->Json = new Json();
            // file input not empty, initialize the class variables
            $this->file = $file;
            @$this->file_name = $this->file['name'];
            @$this->file_type = $this->file['type'];
            @$this->file_tmp_name = $this->file['tmp_name'];
            @$this->file_error = $this->file['error'];
            @$this->file_size = $this->file['size'];
            $this->file_extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
            $this->path_to_folder = $_SERVER['DOCUMENT_ROOT'].'/devi/php-file-uploader/upload-folder';

            // handle empty file inputs
            $this->handleEmptyFile();

            // handle file errors
            $this->handleFileError();

            // handle unallowed extensions
            $this->checkFileExtension();

            // check file size
            $this->checkFileSize();
        }

        // function to handle empty file inputs
        private function handleEmptyFile () {
            if (empty($this->file)) {
                $this->Json->printJson([
                    'success' => false,
                    'message' => 'file can\'t be empty'
                ]);
            }
        }

        // function to check if file has error
        private function handleFileError () {
            if ($this->file_error !== 0) {
                $this->Json->printJson([
                    'success' => false,
                    'message' => 'file error(s) detected'
                ]);
            }
        }

        // function to check if a file extension is allowed
        private function checkFileExtension () {
            if (!in_array($this->file_extension, $this->allowed_extensions)) {
                $this->Json->printJson([
                    'success' => false,
                    'message' => "extension '{$this->file_extension}' not allowed"
                ]);
            }
        }

        // function to get the file size
        private function getFileSize () {
            return $this->file_size;
        }

        // function to check the file size
        function checkFileSize () {
            if ($this->file_size > $this->max_size_allowed) {
                $this->Json->printJson([
                    'success' => false,
                    'message' => 'file size too big'
                ]);
            }
        }

        // function to assign a random name to a file
        function setFileName () {
            $randomString = str_shuffle(md5(microtime().time()));
            $this->file_name = "{$randomString}.{$this->file_extension}";
        }

        // function to get a file name
        function getFileName () {
            return $this->file_name;
        }

        // function to check if file already exists
        private function fileExists () {
            return file_exists("{$this->path_to_folder}/{$this->file_name}");
        }

        // function to handle if file already exists in the current directory
        private function handleFilePresence () {
            if ($this->fileExists()) {
                // set new file name
                $this->setFileName();
            }
        }

        // upload
        function upload () {
            // check if file already exists
            $this->handleFilePresence();
            
            if (@move_uploaded_file($this->file_tmp_name, "{$this->path_to_folder}/{$this->file_name}")) {
                // file uploaded
                $this->Json->printJson([
                    'success' => true,
                    'data' => [
                        'file_name' => $this->getFileName()
                    ]
                ]);
            } else {
                // file could'nt be uploaded
                $this->Json->printJson([
                    'success' => false,
                    'message' => 'file could\'nt be uploaded'
                ]);
            }
        }
    }
?>