<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>

<script type="text/javascript">
    const courses1 = document.querySelector('#courses1');
    courses1.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Courses</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>
    <div class="container-fluid">
        <h3>Course Management</h3>
        <div class="table-box">
            <div class="card-header">List of Courses
                <div class="plus-button">
                    <button type="button" name="add_course" id="add_course" title="Add Course" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#addcourseModal"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="courseTableData">

            </div>
        </div>
    </div>
    <br>
    </div>

    <!-- -------------------------- Add Courses Modal -------------------------- -->
    <div id="addcourseModal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="add_course_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Add Course</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Course Name</b></label>
                            <input type="text" name="add_course_name" id="add_course_name" class="form-control" placeholder="Input Course Name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="add_course_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- --------------------------- Course Edit Modal ------------------------- -->
    <div class="modal fade" id="course_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="course_edit_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Edit Course Info</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <input type="hidden" id="course_id_edit" name="course_id_edit">
                    <div style="padding-top: 15px;" class="modal-body">
                        <div class="form-group">
                            <label><b>Course Name</b></label>
                            <input type="text" name="course_name_edit" id="course_name_edit" class="form-control" placeholder="Input Class Name" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label><b>Status</b></label>
                            <select class="form-control" name="course_status_edit" id="course_status_edit" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="Enabled">Enabled</option>
                                <option value="Disabled">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="update_course_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- --------------------------------- Scripts ----------------------------- -->
    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############### add data script ##############
            $(add_course_modal_form).submit(function(e) {
                e.preventDefault();
                var course_name = $('#add_course_name').val();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'course_add': true,
                        'course_name': course_name,
                    },
                    success: function(response) {
                        $('#addcourseModal').modal('hide');
                        getdata();
                        $('#add_course_name').val("");
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });

            // ############# delete data script #############
            $(document).on("click", ".delete_course_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var course_id = $(this).closest('tr').find('#course_id').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'course_del': true,
                                    'course_id': course_id,
                                },
                                success: function(response) {
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
            $(document).on("click", ".course_edit_btn", function() {
                var course_id = $(this).closest('tr').find('#course_id').text();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'course_edit': true,
                        'course_id': course_id,
                    },
                    success: function(response) {
                        $.each(response, function(key, crs_edit) {
                            $('#course_id_edit').val(crs_edit['course_id']);
                            $('#course_name_edit').val(crs_edit['course_name']);
                            $('#course_status_edit').val(crs_edit['status']);
                        });
                        $('#course_edit_modal').modal('show');
                    }
                });
            });

            // ############# update data script #############
            $('#course_edit_modal_form').submit(function(e) {
                e.preventDefault();
                var course_id_update = $('#course_id_edit').val();
                var course_name_update = $('#course_name_edit').val();
                var course_status_update = $('#course_status_edit').val();
                $.ajax({
                    type: "POST",
                    url: "assets/update.php",
                    data: {
                        'course_update': true,
                        'course_id_update': course_id_update,
                        'course_name_update': course_name_update,
                        'course_status_update': course_status_update,
                    },
                    success: function(response) {
                        $('#course_edit_modal').modal('hide');
                        getdata();
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });
        });

        // ############### fetch data with pagination ###############
        $(document).on("click", ".page-link", function() {
            var page = $(this).attr("id");
            getdata(page);
        });

        function getdata(page) {
            $.ajax({
                type: "POST",
                url: "assets/data.php",
                data: {
                    'course_data': true,
                    'page': page,
                },
                success: function(response) {
                    $(".courseTableData").html(response)

                }
            });
        }
    </script>

    <?php unset($_SESSION['curr_page']); ?>

</body>

</html>