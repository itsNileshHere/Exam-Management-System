<?php
include "../connection.php";
include "assets/header.php";
@session_start();
if (!isset($_SESSION['exam_id'])) {
    echo "<script>history.back();</script>";
    die();
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Exam Results</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>
    <div id="wrapper">
        <?php
        // add_exam Table
        $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
        $result1 = mysqli_query($db, $sql1);
        $res1 = mysqli_fetch_array($result1);

        // Joining add_exam with exam_answers
        $sql2 = "SELECT exam_answers.question, exam_answers.answered, add_question.correct_answer, add_exam.correct, add_exam.wrong
            FROM `exam_answers`
            INNER JOIN `add_exam`
            ON exam_answers.exam_title = add_exam.exam_title
            INNER JOIN `add_question`
            ON exam_answers.question = add_question.question
            AND exam_answers.exam_title = add_question.exam_title
            WHERE exam_answers.exam_title = '{$res1['exam_title']}' AND exam_answers.std_id = '{$_SESSION['std_id']}'";

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

        // add_question Table
        $sql4 = "SELECT * FROM `add_question` WHERE `exam_title` = '{$res1['exam_title']}'";
        $result4 = mysqli_query($db, $sql4);
        $total_records = mysqli_num_rows($result4);

        // exam_answers Table
        $sql5 = "SELECT * FROM `exam_answers` WHERE `std_id` = '{$_SESSION['std_id']}' AND `exam_title` = '{$res1['exam_title']}'";
        $result5 = mysqli_query($db, $sql5);
        $i = 0;
        foreach ($result5 as $res5) {
            if ($res5['answered'] != '')
                $i = $i + 1;
        }
        $notAttempted = $total_records - $i;
        ?>
        <div class="res_wrap">
            <div id="exam_ribbon">
                <p id="exam_title"><?php echo $res1['exam_title'] ?></p>
            </div>

            <div id="exam_res">
                <p><span style="margin-right:72px;">Attempted Questions</span> : <span style="margin-left:20px;"><?php echo $i ?></span></p>
                <p><span style="margin-right:25px;">Non Attempted Questions</span> : <span style="margin-left:20px;"><?php echo $notAttempted ?></span></p>
                <p><span style="margin-right:147px;">Overall Marks</span> : <span style="margin-left:20px;"><?php echo $marks ?></span></p>
            </div>

            <div id="buttons">
                <button class="btn btn-success" onclick="window.open('result.php', '_self');">Detailed Result</button>
                <button class="btn btn-primary" onclick="window.open('home.php', '_self');">Back to Home</button>
            </div>
        </div>
    </div>
</body>

</html>