<?php
    private $server_name;
    private $server_ip;

    // constructor
    function __construct () {
        $this->server_name = (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].'/';
    }
?>