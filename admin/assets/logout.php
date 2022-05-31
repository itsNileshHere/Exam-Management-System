<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['full_name'])) {
    unset($_SESSION['full_name']);
}
if (isset($_SESSION['emailid'])) {
    unset($_SESSION['emailid']);
}
if (isset($_SESSION['adm_id'])) {
    unset($_SESSION['adm_id']);
}
session_destroy();

if(isset($_COOKIE['Aemailid'])) {setcookie('Aemailid', '', time() - 7000000, '/');}
if(isset($_COOKIE['Apassword'])) {setcookie('Apassword', '', time() - 7000000, '/');}

header("location:../../login.php");
?>