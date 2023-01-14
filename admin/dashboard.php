<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php"
?>

<script type="text/javascript">
    const dashboard = document.querySelector('#dashboard');
    dashboard.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Dashboard</title>

</head>

<body>

    <div class="container-fluid">

        <!-- ---------------------- Dashboard Cards -------------------- -->

        <h3 style="margin-top: 28px; margin-bottom: 28px;">Dashboard</h3>
        <div class="row row-cols-5">

            <div class="col mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Result Published</div>

                                <?php
                                $dash_result_query = "SELECT * FROM `add_exam` WHERE `status`='Ended'";
                                $dash_result_query_run = mysqli_query($db, $dash_result_query);
                                if ($results = mysqli_num_rows($dash_result_query_run)) {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $results . '</div>';
                                } else {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-award fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Exam</div>

                                <?php
                                $dash_exam_query = "SELECT * FROM `add_exam`";
                                $dash_exam_query_run = mysqli_query($db, $dash_exam_query);
                                if ($exam_total = mysqli_num_rows($dash_exam_query_run)) {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $exam_total . '</div>';
                                } else {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Student
                                </div>

                                <?php
                                $dash_student_query = "SELECT * FROM `add_student`";
                                $dash_student_query_run = mysqli_query($db, $dash_student_query);
                                if ($student_total = mysqli_num_rows($dash_student_query_run)) {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $student_total . '</div>';
                                } else {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Course</div>

                                <?php
                                $dash_course_query = "SELECT * FROM `add_course`";
                                $dash_course_query_run = mysqli_query($db, $dash_course_query);
                                if ($course_total = mysqli_num_rows($dash_course_query_run)) {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $course_total . '</div>';
                                } else {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Classes</div>

                                <?php
                                $dash_class_query = "SELECT * FROM `add_class`";
                                $dash_class_query_run = mysqli_query($db, $dash_class_query);
                                if ($class_total = mysqli_num_rows($dash_class_query_run)) {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">' . $class_total . '</div>';
                                } else {
                                    echo '<div class="h5 mb-0 font-weight-bold text-gray-800">0</div>';
                                }
                                ?>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>

</body>

</html>