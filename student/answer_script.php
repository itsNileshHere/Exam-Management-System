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

    <title>Answer Script</title>

</head>

<body>
    <div id="wrapper">
        <div id="result-answer-wrapper">
            <button class="btn btn-primary back_btn" onclick="history.back()">Go Back</button>
            <div class="answer_sheet">
                <div class="scroll-div">
                    <?php
                    // add_exam Table
                    $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
                    $result1 = mysqli_query($db, $sql1);
                    $res1 = mysqli_fetch_array($result1);
                    $exam_date = date('F j Y', strtotime($res1['exam_date']));

                    // Joining add_exam with exam_answers
                    $sql2 = "SELECT add_question.question, add_question.ans_1, add_question.ans_2, add_question.ans_3, add_question.ans_4, exam_answers.answered, add_question.correct_answer, add_exam.correct, add_exam.wrong
                    FROM `exam_answers`
                    INNER JOIN `add_exam`
                    ON exam_answers.exam_title = add_exam.exam_title
                    INNER JOIN `add_question`
                    ON exam_answers.question = add_question.question
                    AND exam_answers.exam_title = add_question.exam_title
                    WHERE exam_answers.exam_title = '{$res1['exam_title']}' AND exam_answers.std_id = '{$_SESSION['std_id']}'";

                    $result2 = mysqli_query($db, $sql2);
                    $i = 0;
                    foreach ($result2 as $res2) {
                        $i = $i + 1;
                    ?>
                        <p id="questions"><?php echo $i . ') ' . $res2['question'] ?></p>
                        <div id="answers">
                            <p <?php if ($res2['ans_1'] == $res2['correct_answer']) {
                                    echo "class='correct-green'";
                                }
                                if ($res2['ans_1'] == $res2['answered']) {
                                    echo "class='wrong-red'";
                                } ?>><span><?php if ($res2['ans_1'] == $res2['answered']) {
                                                echo "<img src='img/radio-button.svg'>";
                                            } else {
                                                echo "<img src='img/radio-button-unchecked.svg'>";
                                            } ?></span><?php echo $res2['ans_1'] ?> </p>
                            <p <?php if ($res2['ans_2'] == $res2['correct_answer']) {
                                    echo "class='correct-green'";
                                }
                                if ($res2['ans_2'] == $res2['answered']) {
                                    echo "class='wrong-red'";
                                } ?>><span><?php if ($res2['ans_2'] == $res2['answered']) {
                                                echo "<img src='img/radio-button.svg'>";
                                            } else {
                                                echo "<img src='img/radio-button-unchecked.svg'>";
                                            } ?></span><?php echo $res2['ans_2'] ?> </p>
                            <p <?php if ($res2['ans_3'] == $res2['correct_answer']) {
                                    echo "class='correct-green'";
                                }
                                if ($res2['ans_3'] == $res2['answered']) {
                                    echo "class='wrong-red'";
                                } ?>><span><?php if ($res2['ans_3'] == $res2['answered']) {
                                                echo "<img src='img/radio-button.svg'>";
                                            } else {
                                                echo "<img src='img/radio-button-unchecked.svg'>";
                                            } ?></span><?php echo $res2['ans_3'] ?> </p>
                            <p <?php if ($res2['ans_4'] == $res2['correct_answer']) {
                                    echo "class='correct-green'";
                                }
                                if ($res2['ans_4'] == $res2['answered']) {
                                    echo "class='wrong-red'";
                                } ?>><span><?php if ($res2['ans_4'] == $res2['answered']) {
                                                echo "<img src='img/radio-button.svg'>";
                                            } else {
                                                echo "<img src='img/radio-button-unchecked.svg'>";
                                            } ?></span><?php echo $res2['ans_4'] ?> </p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>