<?php

//test new
session_start();
if (!isset($_SESSION['SESSION_EMAIL']) && $_SESSION['SESSION_EMAIL'] != "admin") {
    header("Location: index.php");
    die();
}

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $joining = mysqli_real_escape_string($conn, $_POST['joining']);
    $photo = mysqli_real_escape_string($conn, $_POST['photo']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $empid = mysqli_real_escape_string($conn, $_POST['empid']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            $sql = "INSERT INTO users (name, email,phone,role,joining,status,photo,empid, password, code) 
                VALUES ('{$name}', '{$email}','{$phone}','{$role}','{$joining}','{$status}','{$photo}','{$empid}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions



                echo "</div>";
                $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>" .
                    '<a href=' . '"index.php?verification=' . $code . '">click</a>';
            } else {
                $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form - Brave Coder</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elitfffffffff. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $name;
                                } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $email;
                                } ?>" required>

                            <input type="text" class="phone" name="phone" placeholder="Enter Your phone"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $phone;
                                } ?>" required>
                            <input type="text" class="empid" name="empid" placeholder="Enter Your empid"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $empid;
                                } ?>" required>
                            <input type="text" class="role" name="role" placeholder="Enter Your role"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $role;
                                } ?>" required>
                            <input type="text" class="joining" name="joining" placeholder="Enter Your joining"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $joining;
                                } ?>" required>
                            <input type="text" class="status" name="status" placeholder="Enter Your status"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $status;
                                } ?>" required>
                            <input type="text" class="photo" name="photo" placeholder="Enter Your photo"
                                value="<?php if (isset($_POST['submit'])) {
                                    echo $photo;
                                } ?>" required>

                            <input type="password" class="password" name="password" placeholder="Enter Your Password"
                                required>
                            <input type="password" class="confirm-password" name="confirm-password"
                                placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>