<?php
    class Json {
        private $json_text = '';

        // construct
        function __construct () {
        }

        // printJson
        function printJson ($json_text = '') {
            $this->json_text = $json_text;
            echo json_encode($this->json_text, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            die();
        }
    }
?>