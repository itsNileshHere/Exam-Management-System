<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php"
?>

<script type="text/javascript">
    const exam = document.querySelector('#exam');
    exam.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Add Exam</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>

    <div class="container-fluid pr-5 pl-5">
        <h3>Add Examination</h3>
        <div class="box-container">
            <div class="card-header">Enter Exam Details</div>
            <br>
            <form id="add_exam" name="add_exam" action="" method="POST">

                <div style="padding-right: 12px;">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label fw-600">Course :</label>
                        <div class="col-sm-9">
                            <?php
                            $query2 = "SELECT * FROM `add_course` WHERE `status`='Enabled'";
                            $result2 = mysqli_query($db, $query2);
                            ?>
                            <select class="form-control" name="course" required>
                                <option value="" selected disabled hidden>Select</option>
                                <?php
                                while ($row2 = mysqli_fetch_array($result2)) {
                                ?>
                                    <option value="<?php echo $row2['course_name'] ?>"><?php echo $row2['course_name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-sm-3 col-form-label fw-600">Exam Time Limit :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="exam_time_limit" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="5">5 Minutes</option>
                                <option value="10">10 Minutes</option>
                                <option value="30">30 Minutes</option>
                                <option value="60">1 Hour</option>
                                <option value="120">2 Hours</option>
                                <option value="180">3 Hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-sm-3 col-form-label fw-600">Total Question :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="total_question" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="5">5 Questions</option>
                                <option value="10">10 Questions</option>
                                <option value="25">25 Questions</option>
                                <option value="50">50 Questions</option>
                                <option value="100">100 Questions</option>
                                <option value="200">200 Questions</option>
                                <option value="300">300 Questions</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-sm-3 col-form-label fw-600">Marks for Correct Answer :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="marks_per_correct_answer" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="1">+1 Mark</option>
                                <option value="2">+2 Marks</option>
                                <option value="3">+3 Marks</option>
                                <option value="4">+4 Marks</option>
                                <option value="5">+5 Marks</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-sm-3 col-form-label fw-600">Marks for Wrong Answer :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="marks_per_wrong_answer" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="1">-1 Mark</option>
                                <option value="1.5">-1.5 Marks</option>
                                <option value="2">-2 Marks</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 form-group">
                        <label class="col-sm-3 col-form-label fw-600" for="exam_title">Exam Title :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="exam_title" placeholder="Input Exam Title" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 form-group" style="padding-bottom: 5px;">
                    <label class="col-sm-3 col-form-label fw-600" for="exam_date_time">Exam Date & Time :</label>
                    <div class="row col-sm-9" style="padding-right: 0px; padding-left:8px">
                        <div class="col">
                            <input type="date" class="form-control" name="exam_date" id="exam_date" placeholder="DD-MMM-YYYY" style="border-radius: 5px;" required>
                        </div>
                        <div class="col">
                            <input type="time" class="form-control" name="exam_time" id="exam_time" placeholder="HH:MM AM/PM" required>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; padding-top:10px">
                    <input style="background-color: #2a498b; border-color:#2e2cc9; height: 38px; width: 100px" class="btn btn-primary" type="submit" name="add_exam_btn" id="add_exam_btn" value="Submit">
                </div>
            </form>
        </div>
        <br>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#exam_date").click(function() {
                var placeholderDate = setInterval(function() {
                    if ($('#exam_date').length && $('#exam_date').val().length) {
                        $('#exam_date').removeAttr("placeholder");
                    } else {
                        $('#exam_date').attr('placeholder', 'DD-MMM-YYYY');
                    }
                }, 100);
                $("#add_exam_btn").click(function() {
                    clearInterval(placeholderDate);
                });
            });
        });

        $(document).ready(function() {
            $("#exam_time").click(function() {
                var placeholderTime = setInterval(function() {
                    if ($('#exam_time').length && $('#exam_time').val().length) {
                        $('#exam_time').removeAttr("placeholder");
                    } else {
                        $('#exam_time').attr('placeholder', 'HH:MM AM/PM');
                    }
                }, 100);
                $("#add_exam_btn").click(function() {
                    clearInterval(placeholderTime)
                });
            });
        });
    </script>

    <!-- ---------------- php Code for add_exam ---------------- -->
    <?php
    if (isset($_POST['add_exam_btn'])) {
        $exam_default_status = "Pending";
        mysqli_query($db, "INSERT INTO `add_exam`(`course`, `exam_time_limit`, `total_question`, `correct`, `wrong`, `exam_title`, `exam_date`, `exam_time`, `status`) VALUES('$_POST[course]', '$_POST[exam_time_limit]', '$_POST[total_question]', '$_POST[marks_per_correct_answer]', '$_POST[marks_per_wrong_answer]', '$_POST[exam_title]', '$_POST[exam_date]', '$_POST[exam_time]', '$exam_default_status')");
    ?>
        <script type="text/javascript">
            swal("Success", "Exam Added Successfully", "success");
        </script>
    <?php
    }
    ?>

</body>

</html>