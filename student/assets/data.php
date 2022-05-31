<?php
include "connection.php";

if (isset($_POST['exam_details_btn'])) {
    @session_start();
    $_SESSION['exam_id'] = $_POST['exam_id'];
    die();
}

if (isset($_POST['exam_start_btn'])) {
    @session_start();
    $_SESSION['exam_id'] = $_POST['exam_id'];
    die();
}

// ########## Paginate php code ##########
if (isset($_POST['get_paginate'])) {
    $exam_title = $_POST['exam_title'];

    $limit = 1;
    $selectquery2 = "SELECT * FROM `add_question` WHERE `exam_title` = '$exam_title'";
    $query2 = mysqli_query($db, $selectquery2);
    $total_records = mysqli_num_rows($query2);
    $total_pages = ceil($total_records / $limit);
    $res_array = [];

    for ($i = 1; $i <= $total_pages; $i++) {
        array_push($res_array, $i);
    }
    header('Content-type: application/json');
    echo json_encode($res_array);
    die();
}

// ########## Answer Submit ##########
if (isset($_POST['exam_ans_submit'])) {
    $std_name = $_POST['std_name'];
    $std_email = $_POST['std_email'];
    $question = $_POST['question'];
    $exam_title = $_POST['exam_title'];
    $answered = "";
    if (isset($_POST['answered']))
        $answered = $_POST['answered'];
    // $correct_answer = $_POST['correct_answer'];

    $selectquery3 = "SELECT `question` FROM `exam_answers` WHERE `exam_title` = '$exam_title' AND `question` = '$question' AND `std_email` = '$std_email'";
    $query3 = mysqli_query($db, $selectquery3);

    if (mysqli_num_rows($query3) != 0) {
        $selectquery4 = "UPDATE `exam_answers` SET `answered`='$answered' WHERE `exam_title` = '$exam_title' AND `question` = '$question' AND `std_email` = '$std_email'";
        $query4 = mysqli_query($db, $selectquery4);
    } else {
        $selectquery5 = "INSERT INTO `exam_answers`(`std_name`, `std_email`, `exam_title`, `question`, `answered`) VALUES ('$std_name', '$std_email', '$exam_title', '$question', '$answered')";
        $query5 = mysqli_query($db, $selectquery5);
    }
    die();
}
