<?php
include "../../connection.php";

$limit = 6;
$page = 0;
$output = "";

// ------------------- classes.php fetch table ------------------

if (isset($_POST['class_data'])) {

    $selqueryPaginate = "SELECT * FROM `add_class`";
    $dataNotFound = "<h3 class='text-center not-found-msg'>No Classes Found</h3>";
    $tableHead = '<div id="table" class="table-responsive"><table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                    <th style="display:none;">Class ID</th>
                    <th class="text-center" style="width: 35%;">Class Name</th>
                    <th class="text-center" style="width: 35%;">Status</th>
                    <th class="text-center" colspan="2">Action</th>
                    </tr>
                    </thead><tbody>';
    $endofDiv = '</tbody></table></div>';

    @session_start();
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        $_SESSION['curr_page'] = $_POST['page'];
    } else {
        if (isset($_SESSION['curr_page'])) {
            $page = $_SESSION['curr_page'];
        } else {
            $page = 1;
        }
    }
    $start_from = ($page - 1) * $limit;
    $selectquery = "SELECT * FROM `add_class` LIMIT $start_from, $limit";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        $output .= $tableHead;
        foreach ($query as $res) {
            $output .= '<tr>
            <td id="class_id" style="display:none;">' . $res['class_id'] . '</td>
            <td class="text-center">' . $res['class_name'] . '</td>
            <td class="text-center">' . $res['status'] . '</td>
            <td class="text-center"><i class="fa fa-edit edit_class_btn" style="margin-left: 100px;"></i></td>
            <td class="text-center"><a class="fa fa-trash delete_class_btn" style="margin-right: 100px;"></a></td>
            </tr>';
        }
    } else {
        $output .= $dataNotFound;
    }
    include "pagination.php";
    die();
}

// ------------------- classes.php add -------------------

if (isset($_POST['class_add'])) {
    $class_name = $_POST['class_name'];

    $selectquery = "INSERT INTO `add_class` (`class_name`,`status`) VALUES('$class_name','Enabled')";
    $query = mysqli_query($db, $selectquery);

    if ($query) {
        echo $return = "Class Added Successfully";
    }
}

// ------------------- classes.php edit ------------------

if (isset($_POST['class_edit'])) {
    $class_id = $_POST['class_id'];
    $res_array = [];
    $selectquery = "SELECT * FROM `add_class` WHERE `class_id` = $class_id";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// ------------------- course.php fetch table ------------------

if (isset($_POST['course_data'])) {
    $selqueryPaginate = "SELECT * FROM `add_course`";
    $dataNotFound = "<h3 class='text-center not-found-msg'>No Courses Found</h3>";
    $tableHead = '<div id="table" class="table-responsive"><table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                    <th style="display:none;">Course ID</th>
                    <th class="text-center" style="width: 28%">Course Name</th>
                    <th class="text-center" style="width: 25%">Created On</th>
                    <th class="text-center" style="width: 25%">Status</th>
                    <th class="text-center" style="width: 20%" colspan="2" style="width:16%">Action</th>
                    </tr>
                    </thead><tbody>';
    $endofDiv = '</tbody></table></div>';

    @session_start();
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        $_SESSION['curr_page'] = $_POST['page'];
    } else {
        if (isset($_SESSION['curr_page'])) {
            $page = $_SESSION['curr_page'];
        } else {
            $page = 1;
        }
    }
    $start_from = ($page - 1) * $limit;
    $selectquery = "SELECT * FROM `add_course` LIMIT $start_from, $limit";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        $output .= $tableHead;
        foreach ($query as $res) {
            $output .= '<tr>
            <td id="course_id" style="display:none;">' . $res['course_id'] . '</td>
            <td class="text-center">' . $res['course_name'] . '</td>
            <td class="text-center">' . $res['create_time'] . '</td>
            <td class="text-center">' . $res['status'] . '</td>
            <td class="text-center"><i class="fa fa-edit course_edit_btn" style="margin-left: 40px;"></i></td>
            <td class="text-center"><a class="fa fa-trash delete_course_btn" style="margin-right: 40px;"></a></td>
            </tr>';
        }
    } else {
        $output .= $dataNotFound;
    }
    include "pagination.php";
    die();
}

// ------------------- course.php add -------------------

if (isset($_POST['course_add'])) {
    date_default_timezone_set("Asia/Calcutta");
    $date = date('d-m-Y H:i', time());
    $course_name = $_POST['course_name'];

    $selectquery = "INSERT INTO `add_course`(`course_name`, `create_time`, `status`) VALUES ('$course_name', '$date', 'Enabled')";
    $query = mysqli_query($db, $selectquery);

    if ($query) {
        echo $return = "Course Added Successfully";
    }
}

// ------------------- course.php edit ------------------

if (isset($_POST['course_edit'])) {
    $course_id = $_POST['course_id'];
    $res_array = [];
    $selectquery = "SELECT * FROM `add_course` WHERE `course_id` = $course_id";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// ------------------- manage_course.php fetch table ------------------

if (isset($_POST['manage_course_data'])) {
    $selqueryPaginate = "SELECT * FROM `assign_course`";
    $dataNotFound = "<h3 class='text-center not-found-msg'>No Assigned Courses</h3>";
    $tableHead = '<div id="table" class="table-responsive"><table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                    <th class="text-center" width="25%">Class Name</th>
                    <th class="text-center" width="25%">Course Name</th>
                    <th class="text-center" width="20%">Created On</th>
                    <th class="text-center" width="20%">Action</th>
                    </tr>
                    </thead><tbody>';
    $endofDiv = '</tbody></table></div>';

    @session_start();
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        $_SESSION['curr_page'] = $_POST['page'];
    } else {
        if (isset($_SESSION['curr_page'])) {
            $page = $_SESSION['curr_page'];
        } else {
            $page = 1;
        }
    }
    $start_from = ($page - 1) * $limit;
    $selectquery = "SELECT * FROM `assign_course` LIMIT $start_from, $limit";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        $output .= $tableHead;
        foreach ($query as $res) {
            $output .= '<tr>
            <td id="manage_course_id" style="display:none;">' . $res['assign_id'] . '</td>
            <td class="text-center">' . $res['class_name'] . '</td>
            <td class="text-center">' . $res['course_name'] . '</td>
            <td class="text-center">' . $res['create_time'] . '</td>
            <td class="text-center"><a class="fa fa-trash manage_course_del_btn"></a></td>
            </tr>';
        }
    } else {
        $output .= $dataNotFound;
    }
    include "pagination.php";
    die();
}

// ------------------- manage_course.php add -------------------

if (isset($_POST['course_assign_add'])) {
    date_default_timezone_set("Asia/Calcutta");
    $date = date('d-m-Y H:i', time());
    $class_name_add = $_POST['class_name'];
    $course_name_add = $_POST['course_name'];

    $selectquery = "INSERT INTO `assign_course`(`class_name`, `course_name`, `create_time`) VALUES ('$class_name_add','$course_name_add', '$date')";
    $query = mysqli_query($db, $selectquery);

    if ($query) {
        echo $return = "Course Updated Successfully";
    }
}

// ------------------- manage_student.php fetch table ------------------

if (isset($_POST['student_data'])) {
    $selqueryPaginate = "SELECT * FROM `add_student`";
    $dataNotFound = "<h3 class='text-center not-found-msg'>No Students Found</h3>";
    $tableHead = '<div id="table" class="table-responsive"><table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                    <th style="display:none;">Student ID</th>
                    <th class="pl-4" style="width: 12.8%;">Student Name</th>
                    <th class="text-center" style="width: 8.5%;">Gender</th>
                    <th class="text-center" style="width: 10.5%;">BirthDate</th>
                    <th class="text-center" style="width: 12.5%;">Course</th>
                    <th class="text-center" style="width: 10%;">Year Level</th>
                    <th class="text-center" style="width: 9.5%;">Email ID</th>
                    <th class="text-center" style="width: 8%;">Password</th>
                    <th class="text-center" colspan="2" style="width: 10%;">Action</th>
                    </tr>
                    </thead><tbody>';
    $endofDiv = '</tbody></table></div>';

    @session_start();
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        $_SESSION['curr_page'] = $_POST['page'];
    } else {
        if (isset($_SESSION['curr_page'])) {
            $page = $_SESSION['curr_page'];
        } else {
            $page = 1;
        }
    }
    $start_from = ($page - 1) * $limit;
    $selectquery = "SELECT * FROM `add_student` LIMIT $start_from, $limit";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        $output .= $tableHead;
        foreach ($query as $res) {
            $dob = date('d-m-Y', strtotime($res['dob']));
            $output .= '<tr>
            <td id="student_id" style="display:none;">' . $res['std_id'] . '</td>
            <td class="pl-4">' . $res['std_name'] . '</td>
            <td class="text-center">' . $res['gender'] . '</td>
            <td class="text-center">' . $dob . '</td>
            <td class="text-center">' . $res['course'] . '</td>
            <td class="text-center">' . $res['year'] . '</td>
            <td class="text-center">' . $res['email'] . '</td>
            <td class="text-center">' . $res['password'] . '</td>
            <td class="text-center"><i class="fa fa-edit std_edit_btn"></i></td>
            <td class="text-center"><a class="fa fa-trash std_delete_btn"></a></td>
            </tr>';
        }
    } else {
        $output .= $dataNotFound;
    }
    include "pagination.php";
    die();
}

// ------------------- manage_student.php edit ------------------

if (isset($_POST['std_edit'])) {
    $std_id = $_POST['std_id'];
    $res_array = [];
    $selectquery = "SELECT * FROM `add_student` WHERE `std_id` = $std_id";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// ------------------- manage_exam.php fetch table ------------------

if (isset($_POST['exam_data'])) {
    $selqueryPaginate = "SELECT * FROM `add_exam`";
    $dataNotFound = "<h3 class='text-center not-found-msg'>No Exams Found</h3>";
    $tableHead = '<div id="table" class="table-responsive"><table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                    <th style="display: none;">Exam ID</th>
                    <th class="pl-4">Exam Title</th>
                    <th class="pl-4">Course</th>
                    <th class="text-center">Exam Timetable</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" colspan="2" style="width: 145px;">Action</th>
                    </tr>
                    </thead><tbody>';
    $endofDiv = '</tbody></table></div>';

    @session_start();
    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        $_SESSION['curr_page'] = $_POST['page'];
    } else {
        if (isset($_SESSION['curr_page'])) {
            $page = $_SESSION['curr_page'];
        } else {
            $page = 1;
        }
    }
    $start_from = ($page - 1) * $limit;
    $selectquery = "SELECT * FROM `add_exam` LIMIT $start_from, $limit";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        $output .= $tableHead;
        foreach ($query as $res) {
            $exam_date = date('d-m-Y', strtotime($res['exam_date']));
            $exam_time = date('h:i A', strtotime($res['exam_time']));

            $status_data = "";
            if ($res['status'] == "Pending")
                $status_data = '<span class="badge badge-warning">Pending</span>';
            else if ($res['status'] == "Started")
                $status_data = '<span class="badge badge-success">Started</span>';
            else if ($res['status'] == "Ended")
                $status_data = '<span class="badge badge-secondary">Ended</span>';

            $output .= '<tr>
            <td id="exam_id" style="display:none;">' . $res['exam_id'] . '</td>
            <td id="exam_title" class="pl-4">' . $res['exam_title'] . '</td>
            <td class="pl-4">' . $res['course'] . '</td>
            <td class="text-center">' . $exam_date . ' ' . $exam_time . '</td>
            <td class="text-center">' . $status_data . '</td>
            <td class="text-center"><i class="fa fa-edit edit_exam_btn" style="margin-left: 18px;"></i></td>
            <td class="text-center"><a class="fa fa-trash delete_exam_btn" style="margin-right: 18px;"></a></td>
            </tr>';
        }
    } else {
        $output .= $dataNotFound;
    }
    include "pagination.php";
    die();
}

// ------------------- add_question.php fetch table ------------------

// Question Part
if (isset($_POST['add_question_data'])) {
    $exam_title = $_POST['exam_title'];

    $selectquery = "SELECT * FROM `add_question` WHERE `exam_title` = '$exam_title'";
    $query = mysqli_query($db, $selectquery);
    $res_array = [];

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// ------------------- add_question.php add -------------------

// Question Part
if (isset($_POST['question_add'])) {
    $exam_title_add = $_POST['exam_title'];
    $course_add = $_POST['course'];
    $question = $_POST['question'];
    $ans_1 = $_POST['ans_1'];
    $ans_2 = $_POST['ans_2'];
    $ans_3 = $_POST['ans_3'];
    $ans_4 = $_POST['ans_4'];
    $correct_answer = $_POST['correct_answer'];

    $selectquery = "INSERT INTO `add_question`(`exam_title`, `course`, `question`, `ans_1`, `ans_2`, `ans_3`, `ans_4`, `correct_answer`) VALUES ('$exam_title_add','$course_add','$question','$ans_1','$ans_2','$ans_3','$ans_4','$correct_answer')";
    $query = mysqli_query($db, $selectquery);

    if ($query) {
        echo $return = "Question Added Successfully";
    }
}

// ------------------- add_question.php edit ------------------

// Edit Exam Part
if (isset($_POST['exam_edit'])) {
    $exam_id = $_POST['exam_id'];
    $res_array = [];
    $selectquery = "SELECT * FROM `add_exam` WHERE `exam_id` = $exam_id";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// Question Part
if (isset($_POST['question_edit'])) {
    $question_id = $_POST['question_id'];
    $res_array = [];
    $selectquery = "SELECT * FROM `add_question` WHERE `question_id` = $question_id";
    $query = mysqli_query($db, $selectquery);

    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $res) {
            array_push($res_array, $res);
        }
        header('Content-type: application/json');
        echo json_encode($res_array);
    }
    die();
}

// --------------- Random Token ---------------

if (isset($_POST['randomToken'])) {
    function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
    $randomToken = generateRandomString();
    echo $randomToken;
    die();
}

if (isset($_POST['tokenGen'])) {
    $myToken = $_POST['myToken'];

    $selectquery = "INSERT INTO `admin_reg`(`special_token`) VALUES ('$myToken')";
    $query = mysqli_query($db, $selectquery);

    if ($query) {
        echo $return = "Token Added Successfully";
    }
    die();
}
