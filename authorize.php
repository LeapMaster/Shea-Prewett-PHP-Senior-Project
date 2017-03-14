<?php
// User and PW Authentication
// Change these to a proper UN/PW for the admin page
$username = 'username';
$password = 'password';

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) 
    {
        //The Username/PW are incorrect, send authentication headers
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="LFG Bingo"');
        exit('<h2>Admin</h2>Sorry, you must enter a valid user name and password to ' .
            'access this page.');
    }
?>