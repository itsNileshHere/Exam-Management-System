<?php
@session_start();
if (isset($_SESSION['exam_id'])) {
    unset($_SESSION['exam_id']);
}

include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>

<script type="text/javascript">
    const exam = document.querySelector('#exam');
    exam.classList.add('current');
</script>

<!DOCTYPE html>
<html>

<head>

    <title>List of Exams</title>

</head>

<body>
    <div class="container-fluid">
        <h3>Exam Management</h3>
        <div class="table-box" id="exam_box">
            <p class="card-header">List of Exams</p>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <?php
                    $stdsel = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
                    $stdselquery = mysqli_query($db, $stdsel);
                    $row = mysqli_fetch_array($stdselquery);
                    $validate_course = $row['course'];

                    $selectquery = "SELECT * FROM `add_exam` WHERE `course`='$validate_course'";
                    $query = mysqli_query($db, $selectquery);
                    $nums = mysqli_num_rows($query);
                    if ($nums > 0) {
                    ?>
                        <thead>
                            <tr>
                                <th style="display:none;">Exam ID</th>
                                <th class="pl-4">Exam Name</th>
                                <th class="text-center">Exam Duration</th>
                                <th class="text-center">Result Status</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Timetable</th>
                                <th class="text-center" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res = mysqli_fetch_assoc($query)) {

                                // std_exam_status Table
                                $selectquery1 = "SELECT * FROM `std_exam_status` WHERE `std_id` = '{$_SESSION["std_id"]}' AND `exam_name` = '{$res['exam_title']}'";
                                $query1 = mysqli_query($db, $selectquery1);
                                $row1 = mysqli_fetch_array($query1);
                            ?>
                                <tr>
                                    <td id="exam_id" style="display:none;"><?php echo $res['exam_id'] ?></td>
                                    <td class="pl-4"><?php echo $res['exam_title'] ?></td>
                                    <td class="text-center"><?php echo $res['exam_time_limit'] ?> Minutes</td>
                                    <td class="text-center"><?php
                                                            if ($res['status'] == 'Pending' || $res['status'] == 'Started') {
                                                                if (mysqli_num_rows($query1) > 0) {
                                                                    if ($row1['attendence_status'] == "Ended") {
                                                                        echo 'Published';
                                                                    }
                                                                } else {
                                                                    echo 'Updated Soon';
                                                                }
                                                            } else if ($res['status'] == 'Ended') {
                                                                echo 'Published';
                                                            }
                                                            ?></td>
                                    <?php
                                    $status = "";
                                    if (mysqli_num_rows($query1) > 0) {
                                        if ($row1['attendence_status'] == "Ended") {
                                            $status = "<span class='badge badge-secondary'>Ended</span>";
                                        } else {
                                            if ($res['status'] == "Pending")
                                                $status = "<span class='badge badge-warning'>Pending</span>";
                                            if ($res['status'] == "Started")
                                                $status = "<span class='badge badge-success'>Started</span>";
                                        }
                                    } else {
                                        if ($res['status'] == "Pending")
                                            $status = "<span class='badge badge-warning'>Pending</span>";
                                        if ($res['status'] == "Started")
                                            $status = "<span class='badge badge-success'>Started</span>";
                                        if ($res['status'] == "Ended")
                                            $status = "<span class='badge badge-secondary'>Ended</span>";
                                    }
                                    ?>
                                    <td class="text-center" id="exam_status"><?php echo $status ?></td>
                                    <?php
                                    $exam_date = date('d-m-Y', strtotime($res['exam_date']));
                                    $exam_time = date('h:i A', strtotime($res['exam_time']));
                                    ?>
                                    <td class="text-center"><?php echo $exam_date . ' ' . $exam_time; ?></td>
                                    <td class="text-center" style="padding-right: 2px;"><a class="butn butn-success exam_details_btn">Details</a></td>
                                    <?php
                                    if ($status == "<span class='badge badge-warning'>Pending</span>")
                                        echo '<td class="text-center" style="padding-left: 2px;"><a class="butn butn-danger exam_start_btn disabled">Start</a></td>';
                                    else if ($status == "<span class='badge badge-success'>Started</span>")
                                        echo '<td class="text-center" style="padding-left: 2px;"><a class="butn butn-danger exam_start_btn">Start</a></td>';
                                    else if ($status == "<span class='badge badge-secondary'>Ended</span>")
                                        echo '<td class="text-center" style="padding-left: 2px;"><a class="butn butn-results show_results_btn">Resullt</a></td>';
                                    ?>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<h3 class="text-center" style="padding-top:15px; padding-bottom:15px">No Exams Found</h3>';
                        }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('.exam_details_btn').on('click', function(e) {
            var exam_id = $(this).closest('tr').find('#exam_id').text();
            $.ajax({
                type: 'POST',
                url: 'assets/data.php',
                data: {
                    'exam_details_btn': true,
                    'exam_id': exam_id
                }
            });
            onclick = window.open('exam_details.php', '_self');
        });

        $('.exam_start_btn').on('click', function(e) {
            var exam_id = $(this).closest('tr').find('#exam_id').text();
            $.ajax({
                type: 'POST',
                url: 'assets/data.php',
                data: {
                    'exam_start_btn': true,
                    'exam_id': exam_id
                }
            });
            onclick = window.open('start_exam.php', '_self');
        });

        $('.show_results_btn').on('click', function(e) {
            var exam_id = $(this).closest('tr').find('#exam_id').text();
            $.ajax({
                type: 'POST',
                url: 'assets/data.php',
                data: {
                    'show_results_btn': true,
                    'exam_id': exam_id
                }
            });
            onclick = window.open('result.php', '_self');
        });
    </script>

    <?php
    include "assets/query_update.php"
    ?>

</body>

</html>