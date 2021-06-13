<?php
    spl_autoload_register (function ($class_name) {
        // check if file exists
        $file = $_SERVER['DOCUMENT_ROOT']."/devi/php-file-uploader/helpers/$class_name.php";
        if(file_exists($file)){
            require_once $file;
        }
    });
?>