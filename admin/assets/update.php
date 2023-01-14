<?php
include "../../connection.php";

//  ------------------------- class.php ----------------------- -->

if (isset($_POST['class_update'])) {

    $class_id = $_POST['class_id_update'];
    $class_name = $_POST['class_name_update'];
    $status = $_POST['status_update'];

    $query = "UPDATE `add_class` SET `class_name`='$class_name',`status`='$status' WHERE `class_id`='$class_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo $return = "Class Updated Successfully";
    }
    die();
}

//  ------------------------- course.php ----------------------- -->

if (isset($_POST['course_update'])) {

    $course_id = $_POST['course_id_update'];
    $course_name = $_POST['course_name_update'];
    $status = $_POST['course_status_update'];

    $query = "UPDATE `add_course` SET `course_name`='$course_name',`status`='$status' WHERE `course_id`='$course_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo $return = "Course Updated Successfully";
    }
    die();
}

//  ------------------------- manage_student.php ----------------------- -->

if (isset($_POST['std_update'])) {

    $std_id = $_POST['std_id_update'];
    $std_name = $_POST['std_name_update'];
    $course = $_POST['std_course_update'];
    $year_lvl = $_POST['year_lvl_update'];
    $emailid = $_POST['emailid_update'];
    $password = $_POST['password_update'];

    $query = "UPDATE `add_student` SET `std_name`='$std_name',`course`='$course',`year`='$year_lvl',`email`='$emailid',`password`='$password' WHERE `std_id`='$std_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo $return = "Data Updated Successfully";
    }
    die();
}

//  ------------------------- add_question.php ----------------------- -->

// Exam Part
if (isset($_POST['exam_page_update'])) {

    $exam_id = $_POST['exam_id_update'];
    $status_exam = $_POST['exam_status_update'];
    $exam_title = $_POST['exam_title_update'];
    $course_exam = $_POST['exam_course_update'];
    $total_question = $_POST['total_question_update'];
    $exam_time_limit = $_POST['exam_time_limit_update'];
    $correct = $_POST['marks_per_correct_answer_update'];
    $wrong = $_POST['marks_per_wrong_answer_update'];

    // echo $return = $exam_id, $status_exam;

    $query = "UPDATE `add_exam` SET `course`='$course_exam',`exam_time_limit`='$exam_time_limit',`total_question`='$total_question',`correct`='$correct',`wrong`='$wrong',`exam_title`='$exam_title',`status`='$status_exam' WHERE `exam_id`='$exam_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo $return = "Data Updated Successfully";
    }
    die();
}

// Question Part
if (isset($_POST['qs_update'])) {

    $question_id = $_POST['question_id_update'];
    $question = $_POST['question_update'];
    $ans_1 = $_POST['ans_1_update'];
    $ans_2 = $_POST['ans_2_update'];
    $ans_3 = $_POST['ans_3_update'];
    $ans_4 = $_POST['ans_4_update'];
    $correct_answer = $_POST['correct_answer_update'];

    $query = "UPDATE `add_question` SET `question`='$question',`ans_1`='$ans_1',`ans_2`='$ans_2',`ans_3`='$ans_3',`ans_4`='$ans_4',`correct_answer`='$correct_answer' WHERE `question_id`='$question_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo $return = "Data Updated Successfully";
    }
    die();
}
?>
