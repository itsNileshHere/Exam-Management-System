<?php
include "../../connection.php";

// ------------------------- classes.php -------------------------

if (isset($_POST['class_del'])) {

    $class_id = $_POST['class_id'];

    $query = "DELETE FROM `add_class` WHERE `class_id` = '$class_id'";
    $queryrun = mysqli_query($db, $query);
    if ($queryrun) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}

// ------------------------- course.php -------------------------

if (isset($_POST['course_del'])) {

    $course_id = $_POST['course_id'];

    $query = "DELETE FROM `add_course` WHERE `course_id` = '$course_id'";
    $queryrun = mysqli_query($db, $query);
    if ($queryrun) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}

// ------------------------- manage_course.php -------------------------

if (isset($_POST['manage_course_del'])) {

    $assign_id = $_POST['manage_course_id'];

    $query = "DELETE FROM `assign_course` WHERE `assign_id` = '$assign_id'";
    $queryrun = mysqli_query($db, $query);
    if ($queryrun) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}

// ------------------------- manage_student.php -------------------------

if (isset($_POST['std_del'])) {

    $stud_id = $_POST['stud_id'];

    $query = "DELETE FROM `add_student` WHERE `std_id` = '$stud_id'";
    $queryrun = mysqli_query($db, $query);
    if ($queryrun) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}

// ------------------------- manage_exam.php -------------------------

if (isset($_POST['exam_del'])) {

    $exam_id = $_POST['exam_id'];
    $exam_title = $_POST['exam_title'];

    ///////// Delete Exam Entry
    $query1 = "DELETE FROM `add_exam` WHERE `exam_id` = '$exam_id'";
    $queryrun1 = mysqli_query($db, $query1);

    ///////// Delete questions related to Exam
    $query2 = "DELETE FROM `add_question` WHERE `exam_title` = '$exam_title'";
    $queryrun2 = mysqli_query($db, $query2);

    if ($queryrun1 and $queryrun2) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}

// ------------------------- add_question.php -------------------------

if (isset($_POST['question_del'])) {

    $question_id = $_POST['question_id'];

    $query = "DELETE FROM `add_question` WHERE `question_id` = '$question_id'";
    $queryrun = mysqli_query($db, $query);
    if ($queryrun) {
        echo $return = "Data Deleted Successfully";
    }
    die();
}
?>