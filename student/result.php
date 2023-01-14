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

    <title>Result Page</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>

    <script disable-devtool-auto src='js/disable-devtools.js'></script>

</head>

<body>
    <div id="wrapper">
        <script type="text/javascript">
            $(document).ready(function() {
                getdata();
            });

            function getdata() {
                $.ajax({
                    type: 'POST',
                    url: 'assets/data.php',
                    data: {
                        'show_results': true,
                        'std_id': "<?php echo $_SESSION['std_id'] ?>",
                        'exam_id': "<?php echo $_SESSION['exam_id'] ?>",
                    },
                    success: function(response) {
                        $("#wrapper").html("")
                        $("#wrapper").html(response)
                    }
                });
            }
        </script>
    </div>

    <div class="print-butn">
        <?php
        // add_exam Table
        $sql1 = "SELECT * FROM `add_exam` WHERE `exam_id` = '{$_SESSION['exam_id']}'";
        $result1 = mysqli_query($db, $sql1);
        $res1 = mysqli_fetch_array($result1);

        // std_exam_status Table
        $sql4 = "SELECT * FROM `std_exam_status` WHERE `std_id` = '{$_SESSION['std_id']}' AND `exam_name` = '{$res1['exam_title']}'";
        $result4 = mysqli_query($db, $sql4);
        $row4 = mysqli_fetch_row($result4);
        if ($row4 > 0) { ?>
            <button class="btn btn-success" id="print_btn">Save as PDF</button>
            <button class="btn btn-primary" id="answer_sheet" onclick="window.open('answer_script.php', '_self');">Answer Sheet</button>
            <button class="btn btn-primary" id="back_btn" onclick="window.open('home.php', '_self');">Back to Home</button>
        <?php } else {
        ?>
            <button class="btn btn-primary" id="back_btn" onclick="window.open('home.php', '_self');">Back to Home</button>
            <script>
                swal({
                    title: "Oh Snap!",
                    text: "Looks Like You haven't attended the Exam",
                    icon: "warning",
                }).then(function() {
                    history.back();
                });
            </script>
        <?php
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        $('#print_btn').click(function(e) {
            e.preventDefault();
            var element = document.getElementById('result-box');
            let r = (Math.random() + 1).toString(36).substring(7);
            var opt = {
                margin: [0, -0.17, 0, 0],
                filename: r + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 5
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        });
    </script>

</body>

</html>