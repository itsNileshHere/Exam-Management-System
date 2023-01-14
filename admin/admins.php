<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php"
?>

<script type="text/javascript">
    const admin_list = document.querySelector('#admin_list');
    admin_list.classList.add('active');
</script>

<!doctype html>
<html lang="en">

<head>

    <title>Admin List</title>

</head>

<body>

    <div class="container-fluid">
        <h3>Manage Admins</h3>
        <div class="table-box">
            <div class="card-header">List of Admins
                <div style="float: right;">
                    <a type="button submit" class="butn butn-success" id="generate_token" data-toggle="modal" data-target="#generate_token_modal">Generate Token</a>
                </div>
            </div>
            <div class="admin_data">
                <div id="table" class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display:none;">Admnin ID</th>
                                <th class="text-center" width="15%">Profile Picture</th>
                                <th class="text-center" width="25%">Full Name</th>
                                <th class="text-center" width="20%">Contact No</th>
                                <th class="text-center" width="20%">Email ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $selectquery = "SELECT * FROM `admin_reg` WHERE `emailid` != ''";
                            $query = mysqli_query($db, $selectquery);
                            while ($res = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td style="display:none;"><?php echo $res['adm_id'] ?></td>
                                    <td class="text-center pt-1 pb-1">
                                        <div id="adm_profile_div"><img src="<?php echo empty($res['image']) ? "img/pfp.png" : $res['image']; ?>"></div>
                                    </td>
                                    <td class="text-center pt-2_1 pb-2_1"><?php echo $res['full_name'] ?></td>
                                    <td class="text-center pt-2_1 pb-2_1"><?php echo $res['contact'] ?></td>
                                    <td class="text-center pt-2_1 pb-2_1"><?php echo $res['emailid'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </div>

    <div class="modal fade" id="generate_token_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Generate Token</h5>
                        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <p id="tokenHideDiv"><i class='fa fa-spinner fa-spin'></i>&nbsp&nbspGenerating Token</p>
                    <div id="tokenShowDiv">
                        <div class="label">Generated Token : </div>
                        <div id="copy_text">
                            <input type="text" class="text" id="myToken" readonly>
                            <button id="copyTokenBtn"><i class="fa fa-clone"></i></button></p>
                        </div>
                        <p>Share this Token with Admin to Register</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="modal_submit_btn" id="token_add_btn" class="btn btn-success modal_submit" value="Use this Token" />
                    <button type="button" class="btn btn-danger modal_cancel" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ######### Generate Token ##########
        $(document).on("click", "#generate_token", function() {
            var token = $.ajax({
                global: false,
                async: false,
                type: "POST",
                url: "assets/data.php",
                data: {
                    'randomToken': true,
                },
                success: function(data) {
                    return data;
                }
            }).responseText;
            document.getElementById("myToken").value = token;

            $('#tokenHideDiv').show();
            $('#tokenHideDiv').delay(2000).fadeOut();

            $('#tokenShowDiv').hide();
            $('#tokenShowDiv').delay(2400).fadeIn();

        });

        // ########## Token Copy BTN ##########
        let copyText = document.querySelector("#copy_text");
        copyText.querySelector("button").addEventListener("click", function() {
            let input = copyText.querySelector("input.text");
            input.select();
            document.execCommand("copy");
            copyText.classList.add("active");
            window.getSelection().removeAllRanges();
            setTimeout(function() {
                copyText.classList.remove("active");
            }, 2500)
        })

        // ########## Add Token BTN ##########
        $(document).on("click", "#token_add_btn", function(e) {
            e.preventDefault();
            var myToken = $('#myToken').val();
            $.ajax({
                type: "POST",
                url: "assets/data.php",
                data: {
                    'tokenGen': true,
                    'myToken': myToken,
                },
                success: function(response) {
                    $('#generate_token_modal').modal('hide');
                    $('#myToken').val("");
                    swal("Success", response, "success", {
                        timer: 2000
                    });
                }
            });
        })
    </script>

</body>

</html>