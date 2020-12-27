<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>ADMIN LOGIN PAGE</title>
</head>

<body>

<form action="#" style="border:3px solid #ccc" method="POST">
    <div class="container">
        <h1>Admin Login Form</h1>
        <hr>

        <label><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="input" name="psw" required>

        <input type="checkbox" onclick="myFunction()">Show Password
        <br>
        <br>
        <script>
            function myFunction() {
                var x = document.getElementById("input");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>

        <div class="cancel_signup">
            <button type="button" class="cancelbtn"><a href="../base/homepage_G.php">Cancel</a></button>
            <button type="submit" class="signupbtn" name="login_admin">Login</button>
        </div>
    </div>
</form>

</body>
</html>

<?php
include("../dbconnect.php");
if (isset($_POST['login_admin'])) {

    $email = $_POST['email'];
    $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    if (empty($email) || empty($psw)) {
        echo '<script language="javascript">';
        echo "alert('Fill all blanks')";
        echo '</script>';
        exit();

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript">';
        echo "alert('Invalid email')";
        echo '</script>';
        exit();

    } else {
        $query = "SELECT * FROM admin WHERE email=?";
        if (isset($conn)) {
            $admin = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($admin, $query)) {
                echo '<script language="javascript">';
                echo "alert('Some connection problem occurs !')";
                echo '</script>';
                exit();
            } else {
                mysqli_stmt_bind_param($admin, "s", $email);
                mysqli_stmt_execute($admin);
                $result = mysqli_stmt_get_result($admin);

                if ($row = mysqli_fetch_assoc($result)) {
                    session_start();
                    $_SESSION['email'] = $row['email'];
                    echo header("Location: adminProfile.php");
                    exit();
                } else {
                    echo '<script language="javascript">';
                    echo "alert('No user match!')";
                    echo '</script>';
                    exit();
                }
            }
        }
    }
}
?>