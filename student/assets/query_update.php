<?php
include "../connection.php";
@session_start();

$sql = "SELECT * FROM `add_exam`";
$result = mysqli_query($db, $sql);
foreach ($result as $res) {

    // Date Check
    date_default_timezone_set('Asia/Kolkata');
    $current_date = date('ymd');
    $exam_date = date('ymd', strtotime($res['exam_date']));

    // Time Check
    date_default_timezone_set('Asia/Kolkata');
    $current_time = date('Hi');
    $remaining_seconds = $res['exam_time_limit'] * 60;
    $start_time = date('Hi', strtotime($res['exam_time']));
    $start_time_in_str = strtotime($res['exam_time']);
    $exam_end_time = date('Hi', ($start_time_in_str + $remaining_seconds));

    if ($current_date < $exam_date) {
        // do nothing
    } else if ($current_date == $exam_date) {
        if ($current_time < $start_time) {
            // do nothing
        } else if ($current_time > $start_time) {
            if ($current_time < $exam_end_time) {
                $query1 = "UPDATE `add_exam` SET `status`='Started' WHERE `exam_title`='{$res['exam_title']}'";
                $query_run = mysqli_query($db, $query1);
            } else if ($current_time == $exam_end_time) {
                $query2 = "UPDATE `add_exam` SET `status`='Ended' WHERE `exam_title`='{$res['exam_title']}'";
                $query_run = mysqli_query($db, $query2);
            } else if ($current_time > $exam_end_time) {
                $query3 = "UPDATE `add_exam` SET `status`='Ended' WHERE `exam_title`='{$res['exam_title']}'";
                $query_run = mysqli_query($db, $query3);
            }
        } else if ($current_time == $start_time) {
            $query4 = "UPDATE `add_exam` SET `status`='Started' WHERE `exam_title`='{$res['exam_title']}'";
            $query_run = mysqli_query($db, $query4);
        }
    } else if ($current_date > $exam_date) {
        $query5 = "UPDATE `add_exam` SET `status`='Ended' WHERE `exam_title`='{$res['exam_title']}'";
        $query_run = mysqli_query($db, $query5);
    }
}
?>