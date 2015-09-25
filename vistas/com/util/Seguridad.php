<?php
session_start();
//var_dump($_SESSION);
if (!isset($_SESSION['ldap_user']))
    header("location:login.php");