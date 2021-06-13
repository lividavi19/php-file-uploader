<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/autoloaders/load_models.php';
    @$file_input = $_FILES['file_input'];

    $uploader = new FileUploader($file_input);
    $uploader->upload();
?>