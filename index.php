<?php
include "connection.php";
@session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Exam Management System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="admin/img/favicon.png">

    <!-- Custom CSS -->
    <link href="style.css?version=1" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />

</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4">
            <section class="navbar-brand">Online Exam Management System</section>
            <ul class="navbar-nav ms-auto my-2">
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            </ul>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Test Your Knowledge and Skills</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75">Utilize your skills with Objective and Descriptive Tests!</p>
                    <p class="text-white-75 mb-5"> Make youself ready for any Exams.</p>
                    <a class="btn btn-primary btn-xl" href="login.php">Get Started</a>
                </div>
            </div>
        </div>
    </header>

    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">About This Project</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-90 mb-4">This is an in-house Project work undertaken in context of partial fulfillment in the Computer Science & Tech. Department for Exam. This Project ensures a safe and secure environment for students to test their Knowledge.</p>
                    <div class="mb-4" id="follow">Follow Me on :
                        <a id="github" href="https://github.com/X-PROFESSOR" target="_blank"><img src="student/img/GitHub.png"></a>
                        <a id="telegram" href="https://t.me/DsntMtter" target="_blank"><img src="student/img/Telegram.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            // Navbar shrink function
            var navbarShrink = function() {
                const navbarCollapsible = document.body.querySelector("#mainNav");
                if (!navbarCollapsible) {
                    return;
                }
                if (window.scrollY === 0) {
                    navbarCollapsible.classList.remove("navbar-shrink");
                } else {
                    navbarCollapsible.classList.add("navbar-shrink");
                }
            };
            navbarShrink();
            document.addEventListener("scroll", navbarShrink);
            const mainNav = document.body.querySelector("#mainNav");
            if (mainNav) {
                new bootstrap.ScrollSpy(document.body, {
                    target: "#mainNav",
                    offset: 74,
                });
            }
        });
    </script>

</body>
</html>