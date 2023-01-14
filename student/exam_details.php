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

    <title>Exam Details</title>

</head>

<body>

    <div class="container-fluid">
        <a onclick="history.back()" class="back-btn" id="exam_back_btn"><i class="fa fa-angle-left"></i></a>
        <div class="exam-details-position">
            <div class="box-container">
                <div class="card-header">Exam Details
                    <div class="exam-start-btn">
                        <?php
                        $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
                        $result1 = mysqli_query($db, $sql1);
                        $row = mysqli_fetch_array($result1);

                        $selectquery1 = "SELECT * FROM `std_exam_status` WHERE `std_id` = '{$_SESSION['exam_id']}' AND `exam_name` = '{$row['exam_title']}'";
                        $query1 = mysqli_query($db, $selectquery1);
                        $row1 = mysqli_fetch_array($query1);

                        $exam_start_TD = date('jS F Y h:i A', strtotime($row['exam_date'] . ' ' . $row['exam_time']));
                        $status = '';
                        if (mysqli_num_rows($query1) > 0) {
                            if ($row1['attendence_status'] == "Ended")
                                $status = 'disabled';
                        } else if ($row['status'] != 'Started') {
                            $status = 'disabled';
                        }
                        ?>
                        <a onclick="window.open('start_exam.php','_self')" class="butn butn-danger <?php echo $status ?>">Start</a>
                    </div>
                </div>
                <br>
                <form action="" method="POST">
                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="exam_title">Exam Title :</label>
                        <div class="col-9">
                            <input type="text" class="form-control color-gray" name="exam_title" required value="<?php echo $row['exam_title'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="course">Course :</label>
                        <div class="col-9">
                            <input type="text" class="form-control color-gray" name="course" required value="<?php echo $row['course'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="exam_time_limit">Exam Time Limit :</label>
                        <div class="col-9">
                            <input type="text" class="form-control color-gray" name="exam_time_limit" required value="<?php echo $row['exam_time_limit'] ?> Minutes" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="total_question">Total Question :</label>
                        <div class="col-9">
                            <input type="text" class="form-control color-gray" name="total_question" required value="<?php echo $row['total_question'] ?> Questions" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="marks_per_correct_answer">Marks for Correct Answer :</label>
                        <div class="col-9">
                            <input style="color: #1ba30b; font-weight: 600" type="text" class="form-control" name="marks_per_correct_answer" required value="+<?php echo $row['correct'];
                                                                                                                                                                if ($row['correct'] == "1") {
                                                                                                                                                                    echo " Mark";
                                                                                                                                                                } else {
                                                                                                                                                                    echo " Marks";
                                                                                                                                                                } ?>" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad">
                        <label class="col col-form-label fw-600" for="marks_per_wrong_answer">Marks for Wrong Answer :</label>
                        <div class="col-9">
                            <input style="color: #d51111; font-weight: 600" type="text" class="form-control" name="marks_per_wrong_answer" required value="-<?php echo $row['wrong'];
                                                                                                                                                            if ($row['wrong'] == "1") {
                                                                                                                                                                echo " Mark";
                                                                                                                                                            } else {
                                                                                                                                                                echo " Marks";
                                                                                                                                                            } ?>" disabled>
                        </div>
                    </div>

                    <div class="row form-group form-pad" style="margin-bottom: 10px;">
                        <label class="col col-form-label fw-600" for="exam_date_time">Exam Date & Time :</label>
                        <div class="col-9">
                            <input type="text" class="form-control color-gray" name="exam_date_time" required value="<?php echo $exam_start_TD; ?>" disabled>
                        </div>
                    </div>

                </form>
            </div>
            <br>
        </div>
    </div>

    <?php
    if (mysqli_num_rows($query1) > 0) {
        if ($row1['attendence_status'] == "Ended") {
            if (isset($_SESSION['exam_id'])) {
                unset($_SESSION['exam_id']);
            }
        }
    } else if ($row['status'] != 'Started') {
        if (isset($_SESSION['exam_id'])) {
            unset($_SESSION['exam_id']);
        }
    }
    ?>
</body>

</html>