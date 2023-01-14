<!DOCTYPE html>
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
    const home = document.querySelector('#home');
    home.classList.add('current');
</script>

<html>

<head>

    <title>index</title>

</head>

<body>
    <div class="container-fluid">
        <h3>Upcoming Exams</h3>
        <?php
        $sql2 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
        $result2 = mysqli_query($db, $sql2);
        $res2 = mysqli_fetch_array($result2);

        $sql1 = "SELECT * FROM `add_exam` WHERE `course` = '{$res2['course']}'";
        $result1 = mysqli_query($db, $sql1);

        foreach ($result1 as $res1) {
            $start_date = strtotime($res1['exam_date']);
            $start_time = strtotime($res1['exam_time']);
            $exam_time_limit = strtotime($res1['exam_time_limit']);
            $remaining_seconds = $res1['exam_time_limit'] * 60;
            $start_time_date = date('F j Y h:i A', strtotime($res1['exam_date'] . ' ' . $res1['exam_time']));
            $end_time_date = date('h:i A', ($start_time + $remaining_seconds));

            $selectquery3 = "SELECT * FROM `std_exam_status` WHERE `std_id` = '{$_SESSION['std_id']}' AND `exam_name` = '{$res1['exam_title']}'";
            $query3 = mysqli_query($db, $selectquery3);
            $row3 = mysqli_fetch_array($query3);

        ?>

            <div class="box-container exams-view">
                <div class="card-header"><?php echo $res1['exam_title'] ?></div>
                <div class="card-containts">
                    <p>Start : <?php echo $start_time_date ?></p>
                    <p>Expired : <?php echo date('F j Y', $start_date) . ' ' . $end_time_date ?></p>
                    <p>Time Zone : Indian Standered Time</p>
                    <p>No of Questions : <?php echo $res1['total_question'] ?></p>
                    <p>Total Duration : <?php echo $res1['exam_time_limit'] ?> Minutes</p>
                </div>
                <?php
                if (mysqli_num_rows($query3) > 0) {
                    if ($row3['attendence_status'] == "Ended") {
                ?>
                        <div id="results_btn">
                            <button type="button" id="<?php echo $res1['exam_id'] ?>" class="btn show_results_btn"><i class="fa fa-list-alt"></i>&nbsp&nbspResults</button>
                        </div>
                    <?php }
                } else if ($res1['status'] == "Ended") { ?>
                    <div id="results_btn">
                        <button type="button" id="<?php echo $res1['exam_id'] ?>" class="btn show_results_btn"><i class="fa fa-list-alt"></i>&nbsp&nbspResults</button>
                    </div>
                <?php } else {
                ?>
                    <div id="details_btn">
                        <button type="button" id="<?php echo $res1['exam_id'] ?>" class="btn btn-primary exam_details_btn"><i class="fas fa-play"></i>&nbsp&nbspDetails</button>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php } ?>
    </div>

    <script type="text/javascript">
        $('.exam_details_btn').on('click', function(e) {
            var exam_id = $(this).attr('id');
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

        $('.show_results_btn').on('click', function(e) {
            var exam_id = $(this).attr('id');
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