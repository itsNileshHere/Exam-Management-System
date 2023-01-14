<?php
include "../connection.php";
include "assets/header.php";
include "assets/navbar.php";
?>
<!doctype html>
<html lang="en">

<head>

    <title>Profile Info</title>

    <!--  Sweet Alert  -->
    <script src="js/sweetalert.js"></script>


</head>

<body>

    <div class="container-fluid">
        <br>
        <div id="profile-position">
            <div class="box-container" id="profile-box">
                <form id="profile" action="" enctype="multipart/form-data" method="POST">
                    <div class="profile-pic">

                        <?php
                        $sql1 = "SELECT * FROM `admin_reg` WHERE `adm_id` = '{$_SESSION["adm_id"]}'";
                        $result1 = mysqli_query($db, $sql1);
                        $res2 = mysqli_fetch_array($result1);
                        ?>

                        <div class="profile-pic-div">
                            <img id="pfpphoto" src="<?php echo empty($res2['image']) ? "img/pfp.png" : $res2['image']; ?>">
                            <input type="file" id="pfpfile" accept=".jpg, .jpeg, .png" name="avatar">
                            <label for="pfpfile" id="pfpuploadBtn"><i class="fa fa-camera" style="font-size: 18px; line-height: 35px"></i></label>
                        </div>
                        <div style="margin-top: 168px;">
                            <p class="font-weight-bold"><?php echo $res2['full_name'] ?> </p>
                            <p class="text-profile-mail"><?php echo $res2['emailid'] ?></p>
                        </div>
                    </div>
                    <div class="profile-info">
                        <div style="padding-left: 10px;">
                            <h4 style="margin-bottom: 20px;">Profile Settings</h4>
                        </div>
                        <div style="padding-left: 10px;">

                            <?php
                            $sql2 = "SELECT * FROM `admin_reg` WHERE `adm_id` = '{$_SESSION["adm_id"]}'";
                            $result2 = mysqli_query($db, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = mysqli_fetch_array($result2)) {
                            ?>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Name</label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name" required value="<?php echo $row['full_name']; ?>">
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Contact Number</label>
                                        <input type="number" name="contact" class="form-control" placeholder="Enter Contact Number" required value="<?php echo $row['contact']; ?>">
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Email ID</label>
                                        <input type="email" name="emailid" class="form-control" placeholder="Enter Email ID" required value="<?php echo $row['emailid']; ?>">
                                    </div>
                                    <div style="padding-bottom: 20px;">
                                        <label style="font-size:12px; font-weight:600">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required value="<?php echo $row['password']; ?>">
                                    </div>
                                    <script src="js/password_icon.js"></script>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div style="text-align: center; padding-top:10px;">
                            <input style="background-color: #2a498b; border-color:#2e2cc9; height: 38px; width: 120px" class="btn btn-primary" type="submit" name="save_profile" value="Save Profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>
    </div>

    <?php
    if (isset($_POST['save_profile'])) {
        $fname = $_POST['full_name'];
        $emailid = $_POST['emailid'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        function generateRandomString($length = 10)  //Generates random strings for pfp name
        {
            return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
        }
        $pfpname = generateRandomString();
        $orig_file = $_FILES["avatar"]["tmp_name"];
        $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);  //Grabs image extension
        $target_dir = 'uploads/';
        $destination = "$target_dir$pfpname.$ext";
        move_uploaded_file($orig_file, $destination);
        if (!empty($_FILES['avatar']['name']))  //Update pfp if file uploaded
        {
            $query = "UPDATE `admin_reg` SET `image`='$destination',`full_name`='$fname',`contact`='$contact',`emailid`='$emailid',`password`='$password' WHERE `adm_id`='$_SESSION[adm_id]'";
            $query_run = mysqli_query($db, $query);
        } else  //Not update pfp if file not uploaded
        {
            $query = "UPDATE `admin_reg` SET `full_name`='$fname',`contact`='$contact',`emailid`='$emailid',`password`='$password' WHERE `adm_id`='$_SESSION[adm_id]'";
            $query_run = mysqli_query($db, $query);
        }
    ?>

        <!--  Sweet Alert  -->

        <script type="text/javascript">
            swal("Success", "Profile Updated Successfully", "success")
                .then(function() {
                    window.location = "profile_info.php";
                });
        </script>
    <?php
    }
    ?>

    <!-- -------------- pfp update JavaScript ------------ -->

    <script type="text/javascript">
        const imgDiv = document.querySelector('.profile-pic-div');
        const img = document.querySelector('#pfpphoto');
        const file = document.querySelector('#pfpfile');
        const uploadBtn = document.querySelector('#pfpuploadBtn');

        imgDiv.addEventListener('mouseenter', function() {
            uploadBtn.style.display = "block"
        });
        imgDiv.addEventListener('mouseleave', function() {
            uploadBtn.style.display = "none"
        });
        file.addEventListener('change', function() {
            const choosedFile = this.files[0];
            if (choosedFile) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    img.setAttribute('src', reader.result);
                });
                reader.readAsDataURL(choosedFile);
            }
        })
    </script>

</body>

</html>