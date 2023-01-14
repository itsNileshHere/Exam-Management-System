<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>

<script type="text/javascript">
    const classes = document.querySelector('#classes');
    classes.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Classes</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

</head>

<body>
    <div class="container-fluid">
        <h3>Classes Management</h3>
        <div class="table-box" id="class_box">
            <div class="card-header">List of Classes
                <div class="plus-button">
                    <button type="button" id="add_class" title="Add Class" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#addclassModal"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="classTableData">

            </div>
        </div>
    </div>
    <br>
    </div>

    <!-- -------------------------- Add Classes Modal -------------------------- -->
    <div class="modal fade" id="addclassModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="add_class_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Add Class</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Class Name</b></label>
                            <input type="text" id="add_class_name" class="form-control" placeholder="Input Class Name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="add_class_btn" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- -------------------------- Class Edit Modal --------------------------- -->
    <div class="modal fade" id="class_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="" method="POST" id="class_edit_modal_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Edit Class Info</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <input type="hidden" id="class_id_edit" name="class_id_edit">
                    <div style="padding-top: 15px;" class="modal-body">
                        <div class="form-group" style="margin-bottom: 12px;">
                            <label><b>Class Name</b></label>
                            <input type="text" name="class_name_edit" id="class_name_edit" class="form-control" placeholder="Input Class Name" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Status</b></label>
                            <select class="form-control" name="status_edit" id="status_edit" required>
                                <option value="" selected disabled hidden>Select</option>
                                <option value="Enabled">Enabled</option>
                                <option value="Disabled">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success modal_submit" value="Add">
                        <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ------------------------------- Scripts ------------------------------- -->
    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############### add data script ##############
            $(add_class_modal_form).submit(function(e) {
                e.preventDefault();
                var class_name = $('#add_class_name').val();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'class_add': true,
                        'class_name': class_name,
                    },
                    success: function(response) {
                        $('#addclassModal').modal('hide');
                        getdata();
                        $('#add_class_name').val("");
                        swal("Success", response, "success", {
                            timer: 2000
                        });
                    }
                });
            });

            // ############# delete data script #############
            $(document).on("click", ".delete_class_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var class_id = $(this).closest('tr').find('#class_id').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'class_del': true,
                                    'class_id': class_id,
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
            $(document).on("click", ".edit_class_btn", function() {
                var class_id = $(this).closest('tr').find('#class_id').text();
                $.ajax({
                    type: "POST",
                    url: "assets/data.php",
                    data: {
                        'class_edit': true,
                        'class_id': class_id,
                    },
                    success: function(response) {
                        $.each(response, function(key, cls_edit) {
                            $('#class_id_edit').val(cls_edit['class_id']);
                            $('#class_name_edit').val(cls_edit['class_name']);
                            $('#status_edit').val(cls_edit['status']);
                        });
                        $('#class_edit_modal').modal('show');
                    }
                });
            });

            // ############# update data script #############
            $('#class_edit_modal_form').submit(function(e) {
                e.preventDefault();
                var class_id_update = $('#class_id_edit').val();
                var class_name_update = $('#class_name_edit').val();
                var status_update = $('#status_edit').val();
                $.ajax({
                    type: "POST",
                    url: "assets/update.php",
                    data: {
                        'class_update': true,
                        'class_id_update': class_id_update,
                        'class_name_update': class_name_update,
                        'status_update': status_update,
                    },
                    success: function(response) {
                        $('#class_edit_modal').modal('hide');
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
                    'class_data': true,
                    'page': page,
                },
                success: function(response) {
                    $(".classTableData").html(response)

                }
            });
        }
    </script>

    <?php unset($_SESSION['curr_page']); ?>

</body>

</html>