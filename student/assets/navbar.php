<?php
include "../connection.php";
@session_start();

// ---------------- Check if logged in or not --------------

if (!isset($_SESSION['std_id'])) {
    header('location:../login.php');
    die();
}
?>
<!DOCTYPE html>

<?php
@$sql1 = "SELECT * FROM `add_student` WHERE `std_id` = '{$_SESSION["std_id"]}'";
$result1 = mysqli_query($db, $sql1);
$res2 = mysqli_fetch_array($result1);
?>

<div id="wrapper">

    <!-- ------------------------------------------- Nav Bar -------------------------------------- -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <nav class="navbar navbar-light navbar-expand bg-white topbar shadow">
                <h4 class="navbar-brand" href="#">Exam Management System</h4>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="home" class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="exam" class="nav-link" href="exam.php">Exam</a>
                    </li>
                </ul>



                <!-- ---------------- Topbar Search ----------------- -->
                <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                <!-- ------------------- Topbar Navbar --------------------- -->

                <ul class="navbar-nav ml-auto">


                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- ------------------- User Information ----------------- -->

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <?php
                            if (isset($_SESSION['std_id'])) {
                            ?>
                                <span class="d-none d-lg-inline text-gray-600 small" style="padding-right: 12px;">
                                    <?php
                                    echo $res2['std_name'];
                                    ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <span class="d-none d-lg-inline text-gray-600 small" style="padding-right: 12px;">Not Logged IN</span>
                            <?php
                            }
                            ?>

                            <img class="img-profile rounded-circle" src="<?php echo empty($res2['image']) ? "img/pfp.png" : $res2['image']; ?>">
                        </a>

                        <!-- ------------------- User Info Dropdown Menu ----------------- -->

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile_info.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <script src="js/sweetalert.js"></script>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item cursor-pointer" id="logout_id">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#logout_id").click(function() {

                                        swal({
                                                title: 'Logout',
                                                text: 'Do you want to logout this Account?',
                                                icon: 'warning',
                                                buttons: true,
                                                dangerMode: true
                                            })
                                            .then((willOUT) => {
                                                if (willOUT) {
                                                    window.location.href = './assets/logout_std.php', {
                                                        icon: 'success',
                                                    }
                                                }
                                            });

                                    });
                                });
                            </script>


                        </div>
                    </li>
                </ul>
            </nav>