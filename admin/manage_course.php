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

    <title>Manage Courses</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>

    <div class="container-fluid">
        <h3>Assign Course</h3>
        <div class="table-box">
            <div class="card-header">List of Classes with Course
                <div class="plus-button">
                    <button type="button" name="assign_course" id="assign_course" title="Assign Course" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#assigncourseModal"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="manage_courseTableData">
                
            </div>
        </div>

    </div>
    <br>
    </div>

    <!-- ---------------------------- Assign Course Modal ----------------------------- -->
    <div class="modal fade" id="assigncourseModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="course_assign_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Assign Course to Class</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Class Name</b></label>
                            <?php
                            $query = "SELECT * FROM `add_class` WHERE `status`='Enabled'";
                            $result = mysqli_query($db, $query);
                            ?>
                            <select name="add_class_name" id="add_class_name" class="form-control" required>
                                <option value="" selected disabled hidden>Select Class</option>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='{$row['class_name']}'>{$row['class_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>Course Name</b></label>
                            <?php
                            $query1 = "SELECT * FROM `add_course` WHERE `status`='Enabled'";
                            $result1 = mysqli_query($db, $query1);
                            ?>
                            <select name="add_course_name" id="add_course_name" class="form-control" required>
                                <option value="" selected disabled hidden>Select Course</option>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    echo "<option value='{$row1['course_name']}'>{$row1['course_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="modal_submit_btn" class="btn btn-success modal_submit" value="Add" />
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ----------------------------------- Scripts ---------------------------------- -->
    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############### assign class script ##############
            $(course_assign_modal_form).submit(function(e) {
                e.preventDefault();
                var class_name = $('#add_class_name').val();
                var course_name = $('#add_course_name').val();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'course_assign_add': true,
                        'class_name': class_name,
                        'course_name': course_name,
                    },
                    success: function(response) {
                        $('#assigncourseModal').modal('hide');
                        getdata();
                        $('#add_class_name').val("");
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });

            // ############# delete data script #############
            $(document).on("click", ".manage_course_del_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var manage_course_id = $(this).closest('tr').find('#manage_course_id').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'manage_course_del': true,
                                    'manage_course_id': manage_course_id,
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
                    'manage_course_data': true,
                    'page': page,
                },
                success: function(response) {
                    $(".manage_courseTableData").html(response)

                }
            });
        }
    </script>

    <?php unset($_SESSION['curr_page']); ?>

</body>

</html>