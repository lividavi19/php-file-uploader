<?php
    class Arrays {
        function arrayKeyExists ($key, $array) {
            return array_key_exists ($key, $array);
        }

        // array size
        function arraySize ($array) {
            return count($array);
        }
    }
?>