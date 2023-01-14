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
<html lang="en">

<head>

    <title>Manage Exams</title>

</head>

<body>

    <div class="container-fluid">

        <h3>Exam Management</h3>
        <div class="table-box">
            <div class="card-header">List of Examinations</div>
            <div class="examTableData">

            </div>
        </div>
    </div>
    <br>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            getdata();

            // ############# delete data script #############
            $(document).on("click", ".delete_exam_btn", function(confirmDelete) {
                swal("Are you sure?", "Data will be Deleted Permanently", "warning", {
                        buttons: ["No", "Yes"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var exam_id = $(this).closest('tr').find('#exam_id').text();
                            var exam_title = $(this).closest('tr').find('#exam_title').text();
                            $.ajax({
                                type: "POST",
                                url: "assets/delete.php",
                                data: {
                                    'exam_del': true,
                                    'exam_id': exam_id,
                                    'exam_title': exam_title,
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
            $(document).on("click", ".edit_exam_btn", function() {
                var exam_id = $(this).closest('tr').find('#exam_id').text();
                window.open("add_question.php?id=" + exam_id, "_self");
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
                    'exam_data': true,
                    'page': page,
                },
                success: function(response) {
                    $(".examTableData").html(response)

                }
            });
        }
    </script>

    <?php unset($_SESSION['curr_page']); ?>

</body>

</html>