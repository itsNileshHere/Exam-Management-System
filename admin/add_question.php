<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>

<script type="text/javascript">
    const exam = document.querySelector('#exam');
    exam.classList.add('active');
</script>

<!doctype html>

<body>

    <div class="container-fluid">
        <h3>Exam Management</h3>
        <div class="row">

            <!-- ###################################### Edit exam part ###################################### -->
            <div class="col">
                <div class="table-box">
                    <div class="card-header">
                        Exam Information
                    </div>
                    <form action="" method="POST" id="exam_info_card">
                        <div style="padding-top: 15px;" class="card-body">
                            <div class="form-group">
                                <label><b>Status</b></label>
                                <select class="form-control" name="status_edit" id="status_edit" required>
                                    <option value="" disabled hidden>Select</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Started">Started</option>
                                    <option value="Ended">Ended</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Exam Title</b></label>
                                <input type="text" name="exam_title_edit" id="exam_title_edit" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Course</b></label>
                                <?php
                                $selcoursequery = "SELECT * FROM `add_course` WHERE `status` = 'Enabled'";
                                $resultquery = mysqli_query($db, $selcoursequery);
                                ?>
                                <select class="form-control" name="course_edit" id="course_edit" required>
                                    <option value="" disabled hidden>Select</option>
                                    <?php
                                    foreach ($resultquery as $res) {
                                        echo '<option value="' . $res["course_name"] . '">' . $res["course_name"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Total Question</b></label>
                                <select class="form-control" name="total_question_edit" id="total_question_edit" required>
                                    <option value="" disabled hidden>Select</option>
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
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Exam Time Limit</b></label>
                                <select class="form-control" name="exam_time_limit_edit" id="exam_time_limit_edit" required>
                                    <option value="" disabled hidden>Select</option>
                                    <option value="5">5 Minutes</option>
                                    <option value="10">10 Minutes</option>
                                    <option value="30">30 Minutes</option>
                                    <option value="60">1 Hour</option>
                                    <option value="120">2 Hours</option>
                                    <option value="180">3 Hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Marks for Correct Answer</b></label>
                                <select class="form-control" name="marks_per_correct_answer_edit" id="marks_per_correct_answer_edit" required>
                                    <option value="" disabled hidden>Select</option>
                                    <option value="1">+1 Mark</option>
                                    <option value="2">+2 Marks</option>
                                    <option value="3">+3 Marks</option>
                                    <option value="4">+4 Marks</option>
                                    <option value="5">+5 Marks</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><b>Marks for Wrong Answer</b></label>
                                <select class="form-control" name="marks_per_wrong_answer_edit" id="marks_per_wrong_answer_edit" required>
                                    <option value="" disabled hidden>Select</option>
                                    <option value="1">-1 Mark</option>
                                    <option value="1.5">-1.5 Marks</option>
                                    <option value="2">-2 Marks</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body text-right pt-2 pb-3">
                            <button type="submit" id="exam_update_btn" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ------------------- Scripts ------------------- -->

            <script type="text/javascript">
                $(document).ready(function() {

                    // ############### fetch question data script ##############
                    var exam_id = <?php echo $_GET['id'] ?>;
                    $.ajax({
                        type: "POST",
                        url: "assets/data.php",
                        data: {
                            'exam_edit': true,
                            'exam_id': exam_id,
                        },
                        success: function(response) {
                            $.each(response, function(key, exam_edit) {
                                $('#status_edit').val(exam_edit['status']);
                                $('#exam_title_edit').val(exam_edit['exam_title']);
                                $('#course_edit').val(exam_edit['course']);
                                $('#total_question_edit').val(exam_edit['total_question']);
                                $('#exam_time_limit_edit').val(exam_edit['exam_time_limit']);
                                $('#marks_per_correct_answer_edit').val(exam_edit['correct']);
                                $('#marks_per_wrong_answer_edit').val(exam_edit['wrong']);
                            });
                        }
                    });

                    // ############# update data script #############
                    $('#exam_info_card').submit(function(e) {
                        e.preventDefault();
                        var exam_id_update = <?php echo $_GET['id'] ?>;
                        var exam_status_update = $('#status_edit').val();
                        var exam_title_update = $('#exam_title_edit').val();
                        var exam_course_update = $('#course_edit').val();
                        var total_question_update = $('#total_question_edit').val();
                        var exam_time_limit_update = $('#exam_time_limit_edit').val();
                        var marks_per_correct_answer_update = $('#marks_per_correct_answer_edit').val();
                        var marks_per_wrong_answer_update = $('#marks_per_wrong_answer_edit').val();

                        $.ajax({
                            type: "POST",
                            url: "assets/update.php",
                            data: {
                                'exam_page_update': true,
                                'exam_id_update': exam_id_update,
                                'exam_status_update': exam_status_update,
                                'exam_title_update': exam_title_update,
                                'exam_course_update': exam_course_update,
                                'total_question_update': total_question_update,
                                'exam_time_limit_update': exam_time_limit_update,
                                'marks_per_correct_answer_update': marks_per_correct_answer_update,
                                'marks_per_wrong_answer_update': marks_per_wrong_answer_update,
                            },
                            success: function(response) {
                                swal("Success", response, "success", {
                                    timer: 2000
                                }).then(function() {
                                    onclick = history.back();
                                });;
                                
                            }
                        });
                    });
                });
            </script>

            <!-- ---------------------------------- End of Edit exam part ----------------------------------- -->

            <!-- ###################################### Questions part ###################################### -->
            <div class="col">
                <div class="qs-box-header">
                    <div class="card-header">
                        Exam Questions
                        <div class="plus-button">
                            <button type="button" name="add_qs_btn" id="add_qs_btn" title="Add Question" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#add_qs_modal"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="over-the-shadow">

                </div>
                <div class="qs-box">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                            <tbody class="addquestiondata">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    </div>

    <!-- ---------------------------- Add Question Modal ---------------------------------- -->
    <div class="modal fade" id="add_qs_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="add_qs_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Add Question</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div style="padding-top: 15px;" class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="add_question" id="add_question" class="form-control" placeholder="Input Question" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="modal-body" style="padding-right: 2px;">
                                <div class="form-group">
                                    <label>Choice 1</label>
                                    <input type="text" name="add_ans_1" id="add_ans_1" class="form-control" placeholder="Input Answer 1" required>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="modal-body" style="padding-left: 2px;">
                                <div class="form-group">
                                    <label>Choice 2</label>
                                    <input type="text" name="add_ans_2" id="add_ans_2" class="form-control" placeholder="Input Answer 2" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="modal-body" style="padding-right: 2px;">
                                <div class="form-group">
                                    <label>Choice 3</label>
                                    <input type="text" name="add_ans_3" id="add_ans_3" class="form-control" placeholder="Input Answer 3" required>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="modal-body" style="padding-left: 2px;">
                                <div class="form-group">
                                    <label>Choice 4</label>
                                    <input type="text" name="add_ans_4" id="add_ans_4" class="form-control" placeholder="Input Answer 4" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;" class="modal-body">
                        <div class="form-group">
                            <label class="text-success">Correct Answer</label>
                            <input type="text" name="add_correct_answer" id="add_correct_answer" class="form-control" placeholder="Input Correct Answer" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="add_qs_modal_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- ---------------------------- edit_question Modal ---------------------------------- -->
    <div class="modal fade" id="edit_qs_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="edit_qs_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Edit Question</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <input type="hidden" id="question_id_edit" name="question_id_edit">
                    <div style="padding-top: 15px;" class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question_edit" id="question_edit" class="form-control" placeholder="Input Question" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="modal-body" style="padding-right: 2px;">
                                <div class="form-group">
                                    <label>Choice 1</label>
                                    <input type="text" name="ans_1_edit" id="ans_1_edit" class="form-control" placeholder="Input Answer 1" required>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="modal-body" style="padding-left: 2px;">
                                <div class="form-group">
                                    <label>Choice 2</label>
                                    <input type="text" name="ans_2_edit" id="ans_2_edit" class="form-control" placeholder="Input Answer 2" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="modal-body" style="padding-right: 2px;">
                                <div class="form-group">
                                    <label>Choice 3</label>
                                    <input type="text" name="ans_3_edit" id="ans_3_edit" class="form-control" placeholder="Input Answer 3" required>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="modal-body" style="padding-left: 2px;">
                                <div class="form-group">
                                    <label>Choice 4</label>
                                    <input type="text" name="ans_4_edit" id="ans_4_edit" class="form-control" placeholder="Input Answer 4" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;" class="modal-body">
                        <div class="form-group">
                            <label class="text-success">Correct Answer</label>
                            <input type="text" name="correct_answer_edit" id="correct_answer_edit" class="form-control" placeholder="Input Correct Answer" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="edit_qs_modal_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ---------------------------------- Scripts ---------------------------------------- -->
    <?php
    $sql = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_GET['id']}'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############### add question script ##############
            $(add_qs_modal_form).submit(function(e) {
                e.preventDefault();
                var exam_title = "<?php echo $row['exam_title'] ?>";
                var course = "<?php echo $row['course'] ?>";
                var question = $('#add_question').val();
                var ans_1 = $('#add_ans_1').val();
                var ans_2 = $('#add_ans_2').val();
                var ans_3 = $('#add_ans_3').val();
                var ans_4 = $('#add_ans_4').val();
                var correct_answer = $('#add_correct_answer').val();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'question_add': true,
                        'exam_title': exam_title,
                        'course': course,
                        'question': question,
                        'ans_1': ans_1,
                        'ans_2': ans_2,
                        'ans_3': ans_3,
                        'ans_4': ans_4,
                        'correct_answer': correct_answer,
                    },
                    success: function(response) {
                        $('#add_qs_modal').modal('hide');
                        $('.over-the-shadow').html("");
                        $('.addquestiondata').html("");
                        getdata();
                        $('#add_question').val("");
                        $('#add_ans_1').val("");
                        $('#add_ans_2').val("");
                        $('#add_ans_3').val("");
                        $('#add_ans_4').val("");
                        $('#add_correct_answer').val("");
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });

            // ############# delete question script #############
            $(document).on("click", ".question_delete_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var question_id = $(this).closest('tr').find('#question_id').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'question_del': true,
                                    'question_id': question_id,
                                },
                                success: function(response) {
                                    $('.over-the-shadow').html("");
                                    $('.addquestiondata').html("");
                                    getdata();
                                    swal(response, {
                                        icon: "success",
                                        timer: 2000
                                    });
                                }
                            });
                        }
                    });
            });

            // ############# edit modal script #############
            $(document).on("click", ".question_edit_btn", function() {
                var question_id = $(this).closest('tr').find('#question_id').text();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'question_edit': true,
                        'question_id': question_id,
                    },
                    success: function(response) {
                        $.each(response, function(key, qs_edit) {
                            $('#question_id_edit').val(qs_edit['question_id']);
                            $('#question_edit').val(qs_edit['question']);
                            $('#ans_1_edit').val(qs_edit['ans_1']);
                            $('#ans_2_edit').val(qs_edit['ans_2']);
                            $('#ans_3_edit').val(qs_edit['ans_3']);
                            $('#ans_4_edit').val(qs_edit['ans_4']);
                            $('#correct_answer_edit').val(qs_edit['correct_answer']);
                        });
                        $('#edit_qs_modal').modal('show');
                    }
                });
            });

            // ############# update question script #############
            $('#edit_qs_modal_form').submit(function(e) {
                e.preventDefault();
                var question_id_update = $('#question_id_edit').val();
                var question_update = $('#question_edit').val();
                var ans_1_update = $('#ans_1_edit').val();
                var ans_2_update = $('#ans_2_edit').val();
                var ans_3_update = $('#ans_3_edit').val();
                var ans_4_update = $('#ans_4_edit').val();
                var correct_answer_update = $('#correct_answer_edit').val();
                $.ajax({
                    type: "POST",
                    url: "assets/update.php",
                    data: {
                        'qs_update': true,
                        'question_id_update': question_id_update,
                        'question_update': question_update,
                        'ans_1_update': ans_1_update,
                        'ans_2_update': ans_2_update,
                        'ans_3_update': ans_3_update,
                        'ans_4_update': ans_4_update,
                        'correct_answer_update': correct_answer_update,
                    },
                    success: function(response) {
                        $('#edit_qs_modal').modal('hide');
                        $('.over-the-shadow').html("");
                        $('.addquestiondata').html("");
                        getdata();
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });
        });

        // ############### Table data Script ###############
        function getdata() {
            var exam_title = "<?php echo $row['exam_title'] ?>";
            $.ajax({
                type: "POST",
                url: "assets/data.php",
                data: {
                    'add_question_data': true,
                    'exam_title': exam_title,
                },
                success: function(response) {
                    var i = 1;
                    if (response) {
                        $(document).ready(function() {
                            $('.over-the-shadow').append(
                                '<div class="row">\
                                <div class="col text-left text-black"><b>Question</b></div>\
                                <div class="col text-right text-black"><b>Action</b></div>\
                                </div>'
                            );
                        });
                        $.each(response, function(key, value) {
                            id = i;
                            $('.addquestiondata').append(
                                '<tr>\
                                <td id="exam_title" style="display:none;">' + value['exam_title'] + '</td>\
                                <td id="question_id" style="display:none;">' + value['question_id'] + '</td>\
                                <td style="width: 78%">\
                                <b>' + [i++] + ') ' + value['question'] + '</b><br>\
                                <div class="pt-1">\
                                <p class="pl-4' + (value['ans_1'] == value['correct_answer'] ? ' text-success' : '') + '">' + 'a.&nbsp' + value['ans_1'] + '</p>\
                                <p class="pl-4' + (value['ans_2'] == value['correct_answer'] ? ' text-success' : '') + '">' + 'b.&nbsp' + value['ans_2'] + '</p>\
                                <p class="pl-4' + (value['ans_3'] == value['correct_answer'] ? ' text-success' : '') + '">' + 'c.&nbsp' + value['ans_3'] + '</p>\
                                <p class="pl-4' + (value['ans_4'] == value['correct_answer'] ? ' text-success' : '') + '">' + 'd.&nbsp' + value['ans_4'] + '</p>\
                                </div>\
                                </td>\
                                <td class="text-center pr-4" style="height:20px"><i class="fa fa-edit question_edit_btn"></i></td>\
                                <td class="text-center"><a class="fa fa-trash question_delete_btn"></a></td>\
                                </tr>');
                        });
                    } else {
                        $(document).ready(function() {
                            $('.over-the-shadow').addClass('qs-not-found');
                            $('.over-the-shadow').append("<h3 class='text-center not-found-msg'>No Questions Found</h3>");
                        });
                    }
                }
            });
        }
    </script>
</body>