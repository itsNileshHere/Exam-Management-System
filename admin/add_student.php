<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php"
?>

<script type="text/javascript">
    const student = document.querySelector('#student');
    student.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Add Student</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>

    <div class="container-fluid pr-5 pl-5">
        <h3>Add Student</h3>
        <div class="box-container">
            <div class="card-header">Enter Student Details</div>
            <br>

            <form id="add_student" name="add_student" action="" method="POST">
                <div class="row mb-3 form-group">
                    <label class="col-sm-3 col-form-label fw-600" for="std_name">Student Name :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="std_name" placeholder="Input Student Name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-600">Gender :</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="gender" required>
                            <option value="" selected disabled hidden>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 form-group">
                    <label class="col-sm-3 col-form-label fw-600" for="birth_date">Date of Birth :</label>
                    <div class="col-sm-9">
                        <input style="border-radius: 5px;" type="date" class="form-control" name="birth_date" id="birth_date" placeholder="DD-MMM-YYYY" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-600">Course Name :</label>
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

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-600">Year Level :</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="year_lvl" required>
                            <option value="" selected disabled hidden>Select</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 form-group" style="padding-bottom: 5px;">
                    <label class="col-sm-3 col-form-label fw-600" for="email_id">Email ID :</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email_id" placeholder="Input Email ID" required>
                    </div>
                </div>

                <div class="row mb-3 form-group" style="padding-bottom: 5px;">
                    <label class="col-sm-3 col-form-label fw-600" for="password">Password :</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" autocomplete="on" placeholder="Input Password" required>
                    </div>
                </div>

                <div style="text-align: center; padding-top:10px">
                    <input style="background-color: #2a498b; border-color:#2e2cc9; height: 38px; width: 115px" class="btn btn-primary" type="submit" name="add_student_btn" id="add_student_btn" value="Add Student">
                </div>

            </form>
        </div>
        <br>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#birth_date").click(function() {
                var placeholderDate = setInterval(function() {
                    if ($('#birth_date').length && $('#birth_date').val().length) {
                        $('#birth_date').removeAttr("placeholder");
                    } else {
                        $('#birth_date').attr('placeholder', 'DD-MMM-YYYY');
                    }
                }, 100);
                $("#add_student_btn").click(function() {
                    clearInterval(placeholderDate);
                });
            });
        });
    </script>

    <!--  add_student php code  -->
    <?php
    if (isset($_POST['add_student_btn'])) {
        mysqli_query($db, "INSERT INTO `add_student`(`std_name`, `gender`, `dob`, `course`, `year`, `email`, `password`) VALUES('$_POST[std_name]', '$_POST[gender]', '$_POST[birth_date]', '$_POST[course]', '$_POST[year_lvl]', '$_POST[email_id]', '$_POST[password]')");
    ?>
        <script type="text/javascript">
            swal("Success", "Student Added Successfully", "success");
        </script>
    <?php
    }
    ?>
</body>

</html>