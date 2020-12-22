<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="main.css">

    <title>REGISTRATION</title>
</head>
<body>
<!-- Navbar -->
<div class="navbar">

    <!-- Left-aligned links (default) -->
    <a href="base/homepage_G.php">Homepage</a>
    <a href="base/aboutUs_G.php">About Us</a>
    <a href="contactUs_G.php">Contact Us</a>
    <a href="base/support_G.php">Support</a>

    <!-- Right-aligned links -->
    <div class="navbar-right">
        <a href="login.php">Login</a>
        <a href="registration.php">Registration</a>
    </div>

</div>

<form action="#" method="POST" style="border:3px solid #ccc">
    <div class="container">
        <h1>Registration</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label><b>Name</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>

        <label><b>Surname</b></label>
        <input type="text" placeholder="Enter Surname" name="surname" required>

        <label><b>Gender</b></label>
        <input type="text" placeholder="Enter F for Female / M for Male" name="gender" required>

        <label><b>Phone Number</b></label>
        <input type="text" placeholder="5XX-XXX-XXXX" name="phone" required>

        <label><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <label><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

        <p>By creating an account you agree to our <a style="color:dodgerblue">Terms & Privacy</a>.</p>

        <div class="cancel_signup">
            <button type="button" class="cancelbtn"><a href="base/homepage_G.php">Cancel</a></button>
            <button type="submit" class="signupbtn" name="signupbtn" onclick="geeks()">Register Now</a></button>
        </div>
    </div>
</form>
</body>
</html>

<?php
error_reporting(0);
session_start();
#$conn = mysqli_connect("localhost", "root", "", "busdb");
include("dbconnect.php");

if (isset($_POST['signupbtn'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $psw = $_POST['psw'];
    $psw_repeat = $_POST['psw-repeat'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
        if(confirm("Invalid email address !")) {
        window.location.href = "../BusTicketly/registration.php"
        }</script>';
        exit();
    } else if ($psw !== $psw_repeat) {
        echo '<script>
        if(confirm("Passwords do not match !")) {
        window.location.href = "../BusTicketly/registration.php"
        }</script>';
        exit();

    } else {
        $registration = "SELECT emailaddress FROM users WHERE emailaddress=?";
        if (isset($conn)) {
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $registration)) {
                echo '<script>
                if(confirm("Some connection troubles !")) {
                window.location.href = "../BusTicketly/registration.php"
                }</script>';
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt); //execute into database
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    echo '<script>
                    if(confirm("User already taken !")) {
                    window.location.href = "../BusTicketly/registration.php"
                    }</script>';
                    exit();
                } else {
                    $registration = "INSERT INTO users(userName,userSurname,gender,emailaddress,mobilePhone, pwd,userType) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $registration)) {
                        echo '<script>
                        if(confirm("Some connection troubles by registering !")) {
                        window.location.href = "../BusTicketly/registration.php"
                        }</script>';
                        exit();
                    } else {
                        $password_hash = password_hash($psw, PASSWORD_DEFAULT);
                        $userType = "registered";
                        mysqli_stmt_bind_param($stmt, "sssssss", $name, $surname, $gender, $email, $phone, $password_hash, $userType);
                        mysqli_stmt_execute($stmt);

                        echo '   
                        <script>
                        if(confirm("You are registered, successfully.\nClick Ok for logging.")) {
                        window.location.href = "../BusTicketly/login.php"
                        }</script>';
                        exit();
                    }
                }
            }
        }
    }
}
?>

