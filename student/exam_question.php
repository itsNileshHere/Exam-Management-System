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

    <title>Exam Question</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

    <script disable-devtool-auto src='js/disable-devtools.js'></script>

</head>

<body>
    <div id="wrapper">
        <div id="qs-content-wrapper" class="d-flex flex-column">
            <?php
            $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
            $result1 = mysqli_query($db, $sql1);
            $res1 = mysqli_fetch_array($result1);

            date_default_timezone_set('Asia/Kolkata');
            $exam_start_time = strtotime($res1['exam_time']);
            $total_second = $res1['exam_time_limit'] * 60;
            $exam_end_time = date('H:i', ($exam_start_time + $total_second));
            $remaining_minutes = strtotime($exam_end_time) - time();

            include "assets/TimeCircle.php";
            ?>
            <nav class="navbar navbar-dark navbar-expand bg-blue qs-topbar shadow">
                <p class="navbar-brand"><span style="font-weight: 600;">Test Name - </span><?php echo $res1['exam_title'] ?></p>
                <?php
                $sql2 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
                $result2 = mysqli_query($db, $sql2);
                $res2 = mysqli_fetch_array($result2);
                ?>
            </nav>

            <div id="qs-content">
                <div class="question-part">
                    <p id="qs_id">

                    </p>
                    <div id="QnA">
                        <?php
                        $limit = 1;
                        $selectquery2 = "SELECT * FROM `add_question` WHERE `exam_title` = '{$res1['exam_title']}'";
                        $query2 = mysqli_query($db, $selectquery2);
                        $total_records = mysqli_num_rows($query2);
                        $total_pages = ceil($total_records / $limit);
                        if (mysqli_num_rows($query2) > 0) {
                            $i = 0;
                            foreach ($query2 as $res3) {
                                $i = $i + 1;
                        ?>
                                <div class="qton" id="<?php echo $i ?>">
                                    <p id="question" class="<?php echo $i ?>"><?php echo "{$res3['question']}" ?></p>

                                    <div id="answer" class="<?php echo $i ?>">
                                        <form>
                                            <div class="form-check pb-2">
                                                <input class="form-check-input" type="radio" name="answer" value="<?php echo $res3['ans_1'] ?>" id="ans_1">
                                                <label class="form-check-label" for="ans_1"><?php echo $res3['ans_1'] ?></label>
                                            </div>
                                            <div class="form-check pb-2">
                                                <input class="form-check-input" type="radio" name="answer" value="<?php echo $res3['ans_2'] ?>" id="ans_2">
                                                <label class="form-check-label" for="ans_2"><?php echo $res3['ans_2'] ?></label>
                                            </div>
                                            <div class="form-check pb-2">
                                                <input class="form-check-input" type="radio" name="answer" value="<?php echo $res3['ans_3'] ?>" id="ans_3">
                                                <label class="form-check-label" for="ans_3"><?php echo $res3['ans_3'] ?></label>
                                            </div>
                                            <div class="form-check pb-2">
                                                <input class="form-check-input" type="radio" name="answer" value="<?php echo $res3['ans_4'] ?>" id="ans_4">
                                                <label class="form-check-label" for="ans_4"><?php echo $res3['ans_4'] ?></label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <div id="footer">
                        <span class="pr-3"><button type="button" class="btn btn-primary" id="previous">Previous</button></span>
                        <span class="pr-2">
                            <button type="button" class="btn btn-primary" id="saveNnext">Save & Next</button>
                            <button type="submit" class="btn btn-danger d-none" id="submitPaper">Submit Exam</button>
                        </span>
                    </div>
                </div>

                <div class="pagination-part">

                    <!-- ####### Timer ####### -->
                    <div id="exam_timer" data-timer="<?php echo $remaining_minutes ?>">

                    </div>

                    <!-- ####### Pagination ####### -->
                    <div class="qs-no-paginate">

                    </div>

                    <!-- ######## Student's Details ######## -->
                    <div id="student_details">
                        <div class="headline">Student Details</div>
                        <div id="std_img">
                            <img src="<?php echo empty($res2['image']) ? "img/pfp.png" : $res2['image']; ?>">
                        </div>
                        <div id="std_profile">
                            <p class="pb-1 fw-700"><?php echo $res2['std_name'] ?></p>
                            <p style="font-size: 15px;"><?php echo $res2['email'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // ########## Timer ##########
        $("#exam_timer").TimeCircles().addListener(function(unit, value, total) {
            if (total < 1) {
                $("#exam_timer").TimeCircles().destroy();
                alert('Exam Time Completed');
                window.open('exam_result.php', '_self');
            }
        });

        $(document).ready(function() {
            paginationData();
            qs_no_append();
            $(".qton").not('[id="1"]').addClass("d-none");

            // Pagination Click
            $(document).on("click", ".numID", function() {
                var page = $(this).attr("id");
                $(".qton#" + page).removeClass("d-none");
                $(".qton").not('[id="' + page + '"]').addClass("d-none");
                qs_no_append(page);
                paginationData(page);
            });

            // Radio Btn event Check
            $("input[name=answer]")
                .on("click", changeEvent)
                .on("keydown", changeEvent);
            function changeEvent(event) {
                if (event.originalEvent.keyCode == 0) {
                    answer_submit();
                } else {
                    answer_submit();
                }
            }

            // Previous Btn Click
            $(document).on("click", "#previous", function() {
                var qs_no = $(".question_number").attr("id");
                var page = Number(qs_no) - 1;
                var last_page = <?php echo $total_pages ?>;
                if (page <= 1) {
                    page = 1;
                    $(".qton#1").removeClass("d-none");
                    $(".qton").not('[id="1"]').addClass("d-none");
                } else {
                    $(".qton").addClass("d-none");
                    $(".qton#" + page).removeClass("d-none");
                }
                qs_no_append(page);
                paginationData(page);
            })

            // Save Btn click
            $(document).on("click", "#saveNnext", function() {
                var qs_no = $(".question_number").attr("id");
                var page = Number(qs_no) + 1;
                var last_page = <?php echo $total_pages ?>;
                if (page >= last_page) {
                    page = last_page;
                    $("#saveNnext").addClass("d-none");
                    $("#submitPaper").removeClass("d-none");

                    $(".qton#" + page).removeClass("d-none");
                    $(".qton").not('[id="' + page + '"]').addClass("d-none");
                } else {
                    $(".qton").addClass("d-none");
                    $(".qton#" + page).removeClass("d-none");
                }
                answer_submit();
                qs_no_append(page);
                paginationData(page);
            })

            // Submit Btn click
            $(document).on("click", "#submitPaper", function() {
                var qs_no = $(".question_number").attr("id");
                var last_page = <?php echo $total_pages ?>;
                if (qs_no == last_page) {
                    answer_submit();
                    swal("Are you sure?", "You want to Submit the Exam", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    }).then(Submit => {
                        if (Submit) {
                            swal("Success", "Exam Submitted Successfully", "success", {
                                timer: 2000
                            }).then(function() {
                                window.location.href = "exam_result.php";
                            })
                        }
                    });
                }
            });

            // ######### submit answers #########
            function answer_submit() {
                var std_id = "<?php echo $_SESSION['std_id'] ?>";
                var std_name = "<?php echo $res2['std_name'] ?>";
                var std_email = "<?php echo $res2['email'] ?>";
                var exam_title = "<?php echo $res1['exam_title'] ?>";
                var qton_no = $(".question_number").attr("id");
                var question = $("#question." + qton_no).html();
                var answered = $("." + qton_no + " input[name='answer']:checked").val();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'exam_ans_submit': true,
                        'std_id': std_id,
                        'std_name': std_name,
                        'std_email': std_email,
                        'exam_title': exam_title,
                        'question': question,
                        'answered': answered,
                    },
                    success: function(response) {}
                });
            }

            // ######### qs_no append ########
            function qs_no_append(page) {
                var qs_marks = <?php echo $res1['correct'] ?>;
                if (page == undefined)
                    page = 1;
                $('#qs_id').html("").append(
                    '<span class="question_number" id="' + page + '">Question : ' + page + '</span>\
                    <span class="float-right qs_marks">(Marks : ' + qs_marks + ')</span>');
            }

            // ########## pagination function ##########
            function paginationData(page) {
                if (page == undefined)
                    page = 1;
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'get_paginate': true,
                        'exam_title': "<?php echo $res1['exam_title'] ?>",
                    },
                    success: function(response) {
                        $('.qs-no-paginate').html("");
                        num_Class();
                        $.each(response, function(key, value) {
                            var numBtnClass = "num-NotSelected";
                            var last_page = <?php echo $total_pages ?>;
                            if (page == last_page) {
                                $("#saveNnext").addClass("d-none");
                                $("#submitPaper").removeClass("d-none");
                            } else {
                                $("#submitPaper").addClass("d-none");
                                $("#saveNnext").removeClass("d-none");
                            }
                            if (page == value)
                                numBtnClass = "num-Selected";
                            $('.qs-no-paginate').append(
                                '<button class="numID ' + numBtnClass + '" id="' + value + '">' + value + '</button>');
                        });
                    }
                });
            }

            // ########## Legends class function ##########
            function num_Class() {
                $(document).ready(function() {
                    var Attempted = $('.qs-no-paginate > .num-Attempted').length;
                    var NotAttempted = $('.qs-no-paginate > .num-NotAttempted').length;
                    var Review = $('.qs-no-paginate > .num-Review').length;
                    var NotAnswered = $('.qs-no-paginate > .num-NotAnswered').length;

                    $('.legends').html("").append('<div class="headline">Overall Summary</div>\
                        <div><button class="numID num-Attempted">' + Attempted + '</button>Attempted</div>\
                        <div><button class="numID num-NotAttempted">' + NotAttempted + '</button>Not Attempted</div>\
                        <div><button class="numID num-Review">' + Review + '</button>Marked for Review</div>\
                        <div><button class="numID num-NotAnswered">' + NotAnswered + '</button>Not Answered</div>');
                });
            }
        });
    </script>

</body>

</html>