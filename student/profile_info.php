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
                        $sql1 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
                        $result1 = mysqli_query($db, $sql1);
                        $res2 = mysqli_fetch_array($result1);
                        ?>

                        <div class="profile-pic-div">
                            <img id="pfpphoto" src="<?php echo empty($res2['image']) ? "img/pfp.png" : $res2['image']; ?>">
                            <input type="file" id="pfpfile" accept=".jpg, .jpeg, .png" name="avatar">
                            <label for="pfpfile" id="pfpuploadBtn"><i class="fa fa-camera" style="font-size: 18px; line-height: 35px"></i></label>
                        </div>
                        <div style="margin-top: 168px;">
                            <p class="font-weight-bold"><?php echo $res2['std_name'] ?> </p>
                            <p class="text-profile-mail"><?php echo $res2['email'] ?></p>
                        </div>
                    </div>
                    <div class="profile-info">
                        <div style="padding-left: 10px;">
                            <h4>Profile Settings</h4>
                        </div>
                        <div style="padding-left: 10px;">

                            <?php
                            $sql2 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
                            $result2 = mysqli_query($db, $sql2);
                            if (mysqli_num_rows($result2) > 0) {
                                while ($row = mysqli_fetch_array($result2)) {
                                    $Bdate = date('Y-m-d', strtotime($row['dob']));
                            ?>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Name</label>
                                        <input type="text" name="std_name" class="form-control" placeholder="Enter Full Name" required value="<?php echo $row['std_name']; ?>">
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Date of Birth</label>
                                        <input style="border-radius: 5px;" type="date" name="dob" id="dob" class="form-control" required value="<?php echo $Bdate; ?>">
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Email ID</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email ID" required value="<?php echo $row['email']; ?>">
                                    </div>
                                    <div style="padding-bottom: 5px;">
                                        <label style="font-size:12px; font-weight:600">Course Name</label>
                                        <input type="text" name="course" class="form-control" placeholder="Enter Course" disabled required value="<?php echo $row['course']; ?>">
                                    </div>
                                    <div style="padding-bottom: 10px;">
                                        <label style="font-size:12px; font-weight:600">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" autocomplete="on" disabled required value="<?php echo $row['password']; ?>">
                                    </div>
                                    <script src="js/password_icon.js"></script>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div style="text-align: center; padding-top:10px;">
                            <input style="background-color: #2a498b; border-color:#2e2cc9; height: 38px; width: 120px" class="btn btn-primary" type="submit" name="save_profile" id="save_profile" value="Save Profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#dob").click(function() {
                var placeholderDate = setInterval(function() {
                    if ($('#dob').length && $('#dob').val().length) {
                        $('#dob').removeAttr("placeholder");
                    } else {
                        $('#dob').attr('placeholder', 'Enter Date of Birth');
                    }
                }, 100);
                $("#save_profile").click(function() {
                    clearInterval(placeholderDate);
                });
            });
        });
    </script>

    <?php
    if (isset($_POST['save_profile'])) {
        $std_name = $_POST['std_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
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
            $query = "UPDATE `add_student` SET `image`='$destination',`std_name`='$std_name',`dob`='$dob',`email`='$email' WHERE `std_id`='$_SESSION[std_id]'";
            $query_run = mysqli_query($db, $query);
        } else  //Not update pfp if file not uploaded
        {
            $query = "UPDATE `add_student` SET `std_name`='$std_name',`dob`='$dob',`email`='$email' WHERE `std_id`='$_SESSION[std_id]'";
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