<?php
include "connection.php";
session_start();

if (isset($_POST['got_std'])) {
    $std_email = $_POST['std_emailid'];
    $std_password = $_POST['std_password'];
    $rememberme_std_check = $_POST['rememberme_std_check'];

    $count = 0;
    $res = mysqli_query($db, "SELECT * FROM `add_student` WHERE email= '$std_email' && password= '$std_password';");
    $count = mysqli_num_rows($res);
    $array1 = mysqli_fetch_array($res);

    if ($count == 0) {
        echo $return = "";
    } else {
        $_SESSION['std_id'] = $array1['std_id'];
        echo $return = "Logged IN Successfully!";
    }

    if ($rememberme_std_check == "true") {
        setcookie('Semailid', $std_email, time() + 86400, '/');
        setcookie('Spassword', $std_password, time() + 86400, '/');
    }

    die();
}

if (isset($_POST['got_adm'])) {
    $adm_email = $_POST['adm_emailID'];
    $adm_password = $_POST['adm_password'];
    $rememberme_adm_check = $_POST['rememberme_adm_check'];

    $count = 0;
    $res = mysqli_query($db, "SELECT * FROM `admin_reg` WHERE emailid= '$adm_email' && password= '$adm_password';");
    $count = mysqli_num_rows($res);
    $array1 = mysqli_fetch_array($res);

    if ($count == 0) {
        echo $return = "";
    } else {
        $_SESSION['adm_id'] = $array1['adm_id'];
        echo $return = "Logged IN Successfully!";
    }

    if ($rememberme_adm_check == "true") {
        setcookie('Aemailid', $adm_email, time() + 86400, '/');
        setcookie('Apassword', $adm_password, time() + 86400, '/');
    }

    die();
}
