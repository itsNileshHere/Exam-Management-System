<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>

<script type="text/javascript">
    const student = document.querySelector('#student');
    student.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Manage Student</title>

</head>

<body>

    <div class="container-fluid">

        <h3>Manage Students</h3>
        <div class="table-box">
            <div class="card-header">List of Students</div>
            <div class="studentDataTable">
                
            </div>
        </div>

    </div>
    <br>
    </div>

    <!-- -------------------------- Student Edit Modal -------------------------- -->
    <div class="modal fade" id="std_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="std_edit_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Edit Student Info</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <input type="hidden" id="std_id_edit" name="std_id_edit">
                    <div style="padding-top: 15px;" class="modal-body">
                        <div class="form-group">
                            <label><b>Student Name</b></label>
                            <input type="text" name="std_name_edit" id="std_name_edit" class="form-control" placeholder="Input Class Name" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Course Name</b></label>
                            <?php
                            $query2 = "SELECT * FROM `add_course`";
                            $result2 = mysqli_query($db, $query2);
                            ?>
                            <select class="form-control" name="course_edit" id="course_edit" required>
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
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Year Level</b></label>
                            <select class="form-control" name="year_lvl_edit" id="year_lvl_edit" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Email ID</b></label>
                            <input type="email" name="emailid_edit" id="emailid_edit" class="form-control" placeholder="Input Email ID" required>
                        </div>
                    </div>
                    <div style="padding-bottom: 10px;" class="modal-body">
                        <div class="form-group">
                            <label><b>Password</b></label>
                            <input type="password" name="password_edit" id="password_edit" class="form-control" placeholder="Input Password" autocomplete="off" required>
                        </div>
                        <script src="js/password_icon.js"></script>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="update_std_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- --------------------------------- Scripts ------------------------------- -->
    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############# delete data script #############
            $(document).on("click", ".std_delete_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var stud_id = $(this).closest('tr').find('#student_id').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'std_del': true,
                                    'stud_id': stud_id,
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
            $(document).on("click", ".std_edit_btn", function() {
                var std_id = $(this).closest('tr').find('#student_id').text();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'std_edit': true,
                        'std_id': std_id,
                    },
                    success: function(response) {
                        $.each(response, function(key, std_edit_data) {
                            $('#std_id_edit').val(std_edit_data['std_id']);
                            $('#std_name_edit').val(std_edit_data['std_name']);
                            $('#course_edit').val(std_edit_data['course']);
                            $('#year_lvl_edit').val(std_edit_data['year']);
                            $('#emailid_edit').val(std_edit_data['email']);
                            $('#password_edit').val(std_edit_data['password']);
                        });
                        $('#std_edit_modal').modal('show');
                    }
                });
            });

            // ############# update data script #############
            $('#std_edit_modal_form').submit(function(e) {
                e.preventDefault();
                var std_id_update = $('#std_id_edit').val();
                var std_name_update = $('#std_name_edit').val();
                var std_course_update = $('#course_edit').val();
                var year_lvl_update = $('#year_lvl_edit').val();
                var emailid_update = $('#emailid_edit').val();
                var password_update = $('#password_edit').val();
                $.ajax({
                    type: "POST",
                    url: "assets/update.php",
                    data: {
                        'std_update': true,
                        'std_id_update': std_id_update,
                        'std_name_update': std_name_update,
                        'std_course_update': std_course_update,
                        'year_lvl_update': year_lvl_update,
                        'emailid_update': emailid_update,
                        'password_update': password_update,
                    },
                    success: function(response) {
                        $('#std_edit_modal').modal('hide');
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
                    'student_data': true,
                    'page': page,
                },
                success: function(response) {
                    $(".studentDataTable").html(response)

                }
            });
        }
    </script>

    <?php unset($_SESSION['curr_page']); ?>

</body>

</html>