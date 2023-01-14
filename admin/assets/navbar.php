<?php
include "../connection.php";
session_start();

// ---------------- Check if logged in or not --------------

if (!isset($_SESSION['adm_id'])) {
    header('location:../login.php');
    die();
}
?>
<!DOCTYPE html>

<?php
@$sql1 = "SELECT * FROM `admin_reg` WHERE `adm_id` = '{$_SESSION["adm_id"]}'";
$result1 = mysqli_query($db, $sql1);
$res2 = mysqli_fetch_array($result1);
?>

<!--  SideBar  -->
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!--  Sidebar  -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-text mx-3">Welcome&nbsp&nbsp</div>
            <?php
            if (isset($_SESSION['adm_id'])) {
            ?>
                <div class="sidebar-brand-icon">
                    <?php
                    $str_name = $res2['full_name'];
                    echo strtok($str_name, " ");
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="sidebar-brand-icon">Admin</div>
            <?php
            }
            ?>
        </a>
        <hr class="sidebar-divider my-0">

        <!--  Dashboard  -->
        <li id="dashboard" class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">

        <!--  Classes  -->
        <li id="classes" class="nav-item">
            <a class="nav-link" href="classes.php">
                <i class="fas fa-door-open"></i>
                <span>Classes</span>
            </a>
        </li>

        <!--  Courses Collapse Menu  -->
        <li id="courses1" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject" aria-expanded="true" aria-controls="collapseSubject">
                <i class="fas fa-book-open"></i>
                <span>Course</span>
            </a>
            <div id="collapseSubject" class="collapse" aria-labelledby="headingSubject" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="course.php">Courses</a>
                    <a class="collapse-item" href="manage_course.php">Manage Courses</a>
                </div>
            </div>
        </li>

        <!--  Student Collapse Menu  -->
        <li id="student" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudent" aria-expanded="true" aria-controls="collapseStudent">
                <i class="fas fa-address-book"></i>
                <span>Student</span>
            </a>
            <div id="collapseStudent" class="collapse" aria-labelledby="headingStudent" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="add_student.php">Add Student</a>
                    <a class="collapse-item" href="manage_student.php">Manage Student</a>
                </div>
            </div>
        </li>

        <!--  Exam Collapse Menu  -->
        <li id="exam" class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExam" aria-expanded="true" aria-controls="collapseExam">
                <i class="fas fa-edit"></i>
                <span>Exam</span>
            </a>
            <div id="collapseExam" class="collapse" aria-labelledby="headingExam" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="add_exam.php">Add Exam</a>
                    <a class="collapse-item" href="manage_exam.php">Manage Exam</a>
                </div>
            </div>
        </li>

        <!--  Admin  -->
        <li id="admin_list" class="nav-item">
            <a class="nav-link" href="admins.php">
                <i class="fas fa-users-cog"></i>
                <span>Admins</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <!--  Exapnd Arrow  -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <script src="js/navbar.js"></script>

    <!--  Nav Bar  -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

                <h2>Online Exam Management System</h2>

                <!--  Topbar Navbar  -->
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!--  User Information  -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <?php
                            if (isset($_SESSION['adm_id'])) {
                            ?>
                                <span class="d-none d-lg-inline text-gray-600 small" style="padding-right: 12px;">
                                    <?php
                                    echo $res2['full_name'];
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle" src="<?php echo empty($res2['image']) ? "img/pfp.png" : $res2['image']; ?>">
                            <?php
                            } else {
                            ?>
                                <span class="d-none d-lg-inline text-gray-600 small" style="padding-right: 12px;">LogIn First</span>
                                <img class="img-profile rounded-circle" src="img/pfp.png">
                            <?php
                            }
                            ?>
                        </a>

                        <!--  User Info Dropdown Menu  -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile_info.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <script src="js/sweetalert.js"></script>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout_id">
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
                                                    window.location.href = './assets/logout.php', {
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