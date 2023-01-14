<?php
include "../../connection.php";

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

if (isset($_POST['show_results_btn'])) {
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
    $std_id = $_POST['std_id'];
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
        $selectquery4 = "UPDATE `exam_answers` SET `std_name`='$std_name', `answered`='$answered' WHERE `exam_title` = '$exam_title' AND `question` = '$question' AND `std_id` = '$std_id'";
        $query4 = mysqli_query($db, $selectquery4);
    } else {
        $selectquery5 = "INSERT INTO `exam_answers`(`std_id`, `std_name`, `std_email`, `exam_title`, `question`, `answered`) VALUES ('$std_id', '$std_name', '$std_email', '$exam_title', '$question', '$answered')";
        $query5 = mysqli_query($db, $selectquery5);
    }
    die();
}

// ########## Exam start Entry ##########
if (isset($_POST['exam_started'])) {
    $std_id = $_POST['std_id'];
    $std_name = $_POST['std_name'];
    $std_email = $_POST['std_email'];
    $exam_name = $_POST['exam_name'];
    $attendence_status = 'Ended';

    $selectquery1 = "SELECT * FROM `std_exam_status` WHERE `std_id` = '$std_id' AND `exam_name` = '$exam_name'";
    $query1 = mysqli_query($db, $selectquery1);
    if (mysqli_num_rows($query1) == 0) {
        $selectquery2 = "INSERT INTO `std_exam_status`(`std_id`, `std_name`, `std_email`, `exam_name`, `attendence_status`) VALUES ('$std_id', '$std_name','$std_email','$exam_name','$attendence_status')";
        $query2 = mysqli_query($db, $selectquery2);
    } else {
        die();
    }
    die();
}

// ########## Show Results ##########
if (isset($_POST['show_results'])) {
    $output = "";
    $exam_id = $_POST['exam_id'];
    $std_id = $_POST['std_id'];

    // add_exam Table
    $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '$exam_id'";
    $result1 = mysqli_query($db, $sql1);
    $res1 = mysqli_fetch_array($result1);
    $exam_date = date('F j Y', strtotime($res1['exam_date']));

    // add_student Table
    $sql3 = "SELECT * FROM `add_student` WHERE `std_id` = '$std_id'";
    $result3 = mysqli_query($db, $sql3);
    $res3 = mysqli_fetch_array($result3);

    // Joining add_exam with exam_answers
    $sql2 = "SELECT exam_answers.question, exam_answers.answered, add_question.correct_answer, add_exam.correct, add_exam.wrong
            FROM `exam_answers`
            INNER JOIN `add_exam`
            ON exam_answers.exam_title = add_exam.exam_title
            INNER JOIN `add_question`
            ON exam_answers.question = add_question.question
            AND exam_answers.exam_title = add_question.exam_title
            WHERE exam_answers.exam_title = '{$res1['exam_title']}' AND exam_answers.std_id = '$std_id'";

    $result2 = mysqli_query($db, $sql2);
    $marks = 0;
    foreach ($result2 as $res2) {
        if ($res2['answered'] == $res2['correct_answer'])
            $marks = $marks + $res2['correct'];
        else if ($res2['answered'] != $res2['correct_answer']) {
            if (empty($res2['answered'])) {
                echo NULL;
            } else {
                $marks = $marks - $res2['wrong'];
            }
        }
    }

    $output .= '<div id="result-wrapper"  style="user-select: none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; -o-user-select: none;">
                    <div class="result-box" id="result-box">
                        <P id="exam_title">' . $res1['exam_title'] . '</P>
                        <div id="head">
                            <div class="left">
                                <p><span>Student Name : </span>' . $res3['std_name'] . '</p>
                                <p><span>Email ID : </span>' . $res3['email'] . '</p>
                                <p><span>Your Score : </span>' . $marks . ' Marks</p>
                            </div>
                            <div class="right">
                                <p><span>Exam Date : </span>' . $exam_date . '</p>
                                <p><span>Exam Duration : </span>' . $res1['exam_time_limit'] . ' Minutes</p>
                            </div>
                        </div>

                        <div class="devider"></div>

                        <div id="ribbon">
                            <a class="ribbonA"></a>
                            <p>Answer Analysis</p>
                            <a class="ribbonB"></a>
                        </div>

                        <div id="marks_body">';

    $pos_mrk = "Marks";
    if ($res1['correct'] == '1')
        $pos_mrk = "Mark";
    $neg_mrk = "Marks";
    if ($res1['wrong'] == '1')
        $neg_mrk = "Mark";

    $output .= '<p id="pos"><span>Positive Marks per Question : </span>' . $res1['correct'] . ' ' . $pos_mrk . '</p>
                <p id="neg"><span>Negative Marks per Question : </span>' . $res1['wrong'] . ' ' . $neg_mrk . '</p>
            </div>
        <div id="table_body">';

    // add_questions Table
    $sql4 = "SELECT * FROM `add_question` WHERE `exam_title` = '{$res1['exam_title']}'";
    $result4 = mysqli_query($db, $sql4);
    $total_records = mysqli_num_rows($result4);

    // exam_answers Table
    $sql5 = "SELECT * FROM `exam_answers` WHERE `std_id` = '$std_id' AND `exam_title` = '{$res1['exam_title']}'";
    $result5 = mysqli_query($db, $sql5);
    $i = 0;
    foreach ($result5 as $res5) {
        if ($res5['answered'] != '')
            $i = $i + 1;
    }
    $notAttempted = $total_records - $i;

    $correct_counter = 0;
    $incorrect_counter = 0;
    foreach ($result2 as $res2) {
        if ($res2['answered'] == $res2['correct_answer'])
            $correct_counter = $correct_counter + 1;
        if ($res2['answered'] != $res2['correct_answer']) {
            if (empty($res2['answered'])) {
                echo NULL;
            } else {
                $incorrect_counter = $incorrect_counter + 1;
            }
        }
    }

    $output .= '<div class="table-responsive">
                    <table class="mb-0">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th style="padding-right: 10px;">Total Questions</th>
                                <th>Attempted Questions</th>
                                <th id="NA">Non Attempted Questinos</th>
                                <th>Correct Answers</th>
                                <th>Incorrect Answers</th>
                                <th>Max Marks</th>
                                <th>Marks Obtained</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $res1['exam_title'] . '</td>
                                <td>' . $total_records . '</td>
                                <td>' . $i . '</td>
                                <td>' . $notAttempted . '</td>
                                <td>' . $correct_counter . '</td>
                                <td>' . $incorrect_counter . '</td>
                                <td>' . $total_records * $res1['correct'] . '</td>
                                <td>' . $marks . '</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>';

    echo $output;
}
