<!-- Code by Brave Coder - https://youtube.com/BraveCoder -->

<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: " . $_SESSION['SESSION_ROLE'] . "/index.php");
    die();
}

include 'config.php';
$msg = "";

if (isset($_GET['verification'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");

        if ($query) {
            $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
        }
    } else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['SESSION_ROLE'] = $row['role'];
        if (empty($row['code'])) {
            $_SESSION['SESSION_EMAIL'] = $email;

            header("Location: " . $row['role'] . "/index.php");
        } else {
            $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>E-Ovijat</title>
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
                        <span class="fa fa-rocket"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>E-Ovijat Web App</h2>
                        <p>Developer: kowshiqueroy@gmail.com</p>
                        <a href='dist'>For Distribution Click Here</a>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password"
                                style="margin-bottom: 2px;" required> <br><br>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        <div class="social-icons">
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
 

</body>

</html>