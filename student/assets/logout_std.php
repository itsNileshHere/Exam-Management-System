<!DOCTYPE html>
<?php
@session_start();
if (isset($_SESSION['std_name'])) {
    unset($_SESSION['std_name']);
}
if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}
if (isset($_SESSION['std_id'])) {
    unset($_SESSION['std_id']);
}
if (isset($_SESSION['exam_id'])) {
    unset($_SESSION['exam_id']);
}
session_destroy();

if(isset($_COOKIE['Semailid'])) {setcookie('Semailid', '', time() - 7000000, '/');}
if(isset($_COOKIE['Spassword'])) {setcookie('Spassword', '', time() - 7000000, '/');}

header("location:../../login.php");
?>