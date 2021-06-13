<?php
    class Strings {
        // trim a string
        function trimString ($s) {
            return trim($s);
        }

        // check length
        function lengthOK ($s){
            return $s != NULL && strlen(trimm($s)) > 0;
        }

        // check if a string is numeric
        function isNumeric ($s) {
            return is_numeric($s);
        }

        // check if a string is integer
        function isInteger ($s) {
            return is_integer($s);
        }

        // chech if email is OK
        function emailOk ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        // chech if url is OK
        function urlOk ($url) {
            return filter_var($url, FILTER_VALIDATE_URL);
        }
    }
?>