<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/devi/php-file-uploader/autoloaders/load_models.php';
    @$file_input = $_FILES['file_input'];

    // print_r($file_input);
    // echo count($file_input);

    $uploader = new FileUploader($file_input);
    $uploader->upload();
?>