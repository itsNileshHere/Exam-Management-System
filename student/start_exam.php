<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";

if (!isset($_SESSION['exam_id'])) {
    echo "<script>history.back();</script>";
    die();
}
?>

    <script type="text/javascript">
        const exam = document.querySelector('#exam');
        exam.classList.add('current');
    </script>

    <!DOCTYPE html>
    <html>

    <head>

        <title>Confirm Exam</title>

    </head>

    <body>

        <div class="container-fluid">
            <div class="exam-check-div">
                <div class="box-container">
                    <?php
                    $sql = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result);

                    $sql2 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION['std_id']}'";
                    $result2 = mysqli_query($db, $sql2);
                    $row2 = mysqli_fetch_array($result2);

                    ?>
                    <div class="card-header"><?php echo $row['exam_title'] ?> Instructions</div>
                    <div class="start_exam_containts">
                        <h3>Please Read the Instructions Carefully</h3>
                        <p class="exam_details">1) Total Questions - <?php echo $row['total_question'] ?></p>
                        <?php
                        $mark = '';
                        if ($row['correct'] == '1')
                            $mark = 'mark';
                        else
                            $mark = 'marks';
                        ?>
                        <p class="exam_details">2) For every correct answer, you will get <?php echo $row['correct'] . ' ' . $mark ?></p>
                        <p class="exam_details">3) Negative Marks : <?php echo $row['wrong'] ?></p>
                        <p class="exam_details">4) Total Time Duration is <?php echo $row['exam_time_limit'] ?> Minutes</p>
                        <p class="exam_details_warn1">5) Once Started, you can't leave untill the timer runs out, else your Exam will be cancelled</p>
                        <p class="exam_details_warn2">6) Do Not Press Back or Refresh button, or Exam will be cancelled</p>
                        <div class="text-center">
                            <div class="form-check pb-3">
                                <input class="form-check-input cursor-pointer" type="checkbox" id="exam_agree_check" onclick="enable()">
                                <label class="form-check-label cursor-pointer" for="exam_agree_check">
                                    Agree and Start the exam
                                </label>
                            </div>
                            <button type="button" class="btn btn-success" onclick="history.back()">Go To Exam Details</button>
                            <button type="button" class="btn btn-primary" id="start_exam_check_btn" disabled>Agree and Continue</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script type="text/javascript">
            function enable() {
                if (document.getElementById("exam_agree_check").checked)
                    document.getElementById("start_exam_check_btn").removeAttribute("disabled");
                else
                    document.getElementById("start_exam_check_btn").disabled = true;
            }

            $('#start_exam_check_btn').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'exam_started': true,
                        'std_id': "<?php echo $_SESSION['std_id'] ?>",
                        'std_name': "<?php echo $row2['std_name'] ?>",
                        'std_email': "<?php echo $row2['email'] ?>",
                        'exam_name': "<?php echo $row['exam_title'] ?>",
                    },
                    success: function(response) {}
                });
                window.open('exam_question.php', '_self')
            });
        </script>

    </body>

    </html>