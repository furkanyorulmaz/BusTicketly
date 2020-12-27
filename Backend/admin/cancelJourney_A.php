<?php
session_start();
include("../dbconnect.php");
if (!isset($_SESSION['email'])) {
    $loginError = "You are not logged in !";
    echo '<script language="javascript">';
    echo "alert('$loginError')";
    echo '</script>';
    include("loginAdmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>CANCEL JOURNEY</title>
</head>
<body>
<!-- Navbar -->
<div class="navbar">

    <!-- Right-aligned links -->
    <div class="navbar-right">
        <a href="../admin/adminProfile.php">Admin Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

</div>

<div class="container">
    <h1>Cancel Journey</h1>
    <hr class="hr_main">
    <form action="#" method="POST">
        <input style="width: 30%" type="text" placeholder="Enter Journey ID:" name="journeyId">
        <button type="submit" class="canceljourney_tiketbtn" name="cancelJourney">Cancel Journey</button>
    </form>
</div>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

<?php
/*session_start();
include("../dbconnect.php");*/
if (isset($_POST['cancelJourney'])) {
    $journeyId = $_POST['journeyId'];
    $deleteJourney = "UPDATE journey SET isCancelled='1' WHERE journeyId='$journeyId';";

    if (isset($conn)) {
        $result = mysqli_query($conn, $deleteJourney);
        if (!$result) {
            #echo "SQL error, check your query !";
            echo '<script> 
                     if(confirm("Journey can not cancelled !")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();

        } else {
            #echo "Journey Canceled";
            echo '<script> 
                     if(confirm("Journey cancelled, successfully.")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        }
    }
}
?>