<?php
session_start();
include("../dbconnect.php");
if (!isset($_SESSION['email'])) {
    $loginError = "You are not logged in";
    echo '<script language="javascript">';
    echo "alert('$loginError')";
    echo '</script>';
    exit();
}

if (isset($_SESSION)) {

$journeyId = $_SESSION['journeyId'];
<<<<<<< HEAD
#echo " ".$journeyId;
$query = "SELECT * FROM journey WHERE journeyId='$journeyId'";

=======
$query = "SELECT * FROM journey WHERE journeyId='$journeyId';";
>>>>>>> main
if (isset($conn)) {
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "SQL error, check your code.";
} else {
?>
<<<<<<< HEAD
=======


>>>>>>> main
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <title>CHOOSE SEAT NUMBER RESERVE RU</title>

    <style>
        /* The container */
        .container_box {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 20px;
            cursor: pointer;
            font-size: 22px;

        }

        /* Hide the browser's default radio button */
        .container_box input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: green;
            border-radius: 20%;
        }


        /* When the radio button is checked, add a blue background */
        .container_box input:checked ~ .checkmark {
            background-color: #f44336;
        }

    </style>

</head>
<body>
<!-- Navbar -->
<div class="navbar">
    <!-- Left-aligned links (default) -->
    <a href="../base/homepage_RU.php">Homepage</a>
    <a href="../base/aboutUs_RU.php">About Us</a>
    <a href="../base/contactUs_RU.php">Contact Us</a>
    <a href="../base/support_RU.php">Support</a>

    <!-- Right-aligned links -->
    <div class="navbar-right">
<<<<<<< HEAD
        <a href="registerUserProfile.php"><?php include "registeredUserName.php"; ?></a>
=======
        <a href="registerUserProfile.php"><?php
            $email = $_SESSION['email'];
            $query = "SELECT * FROM users WHERE emailaddress='$email'";

            $queryConn = mysqli_query($conn, $query);
            if (!$queryConn) {
                echo "Error";
            } else {
                while ($row = mysqli_fetch_array($queryConn)) {
                    $name = $row['userName'];
                    echo " " . $name;
                }
            }
            ?></a>
>>>>>>> main
        <a href="../logout.php">Logout</a>
    </div>
</div>

<<<<<<< HEAD
<form action="registeredReserveInfo.php" method="POST">
    <div class="container">
        <div style="margin-top: -30px; width: 30%;">
            <label for="from">Select Number of Seats: </label>
            <select id="number" style="background-color:lightgray; color:darkblue; width:20% " name="number">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <br>
        <h1>Choose Seat Number</h1>
        <hr class="hr_main">
        <?php

=======
<form action="#" method="POST">
    <div class="container">
        <h1>Choose Seat Number</h1>
        <hr class="hr_main">
        <h3>You can only choose one seat</h3>
        <hr>

        <?php
>>>>>>> main
        while ($row = mysqli_fetch_array($result)) {

            for ($i = 1; $i <= 24; $i++) {
                $query2 = "SELECT * FROM reservation WHERE journeyId='$journeyId' AND seatId='$i';";
                $res1 = mysqli_query($conn, $query2);

                $query3 = "SELECT * FROM ticket WHERE journeyId='$journeyId' AND seatId='$i';";
                $res2 = mysqli_query($conn, $query3);

                if (mysqli_num_rows($res1) > 0 || mysqli_num_rows($res2) > 0) {

                    echo '    
                    <div class="column">
                        <label class="container_box">' . $i . '
<<<<<<< HEAD
                            <input type="checkbox" value="' . $i . '" name="seats[]" checked="checked" disabled="disabled">
=======
                            <input type="checkbox" value="' . $i . '" name="seat" checked="checked" disabled="disabled">
>>>>>>> main
                            <span class="checkmark"></span>
                        </label>
                    </div>';

<<<<<<< HEAD

=======
>>>>>>> main
                } else {

                    echo '    
                    <div class="column">
                        <label class="container_box">' . $i . '
<<<<<<< HEAD
                            <input type="checkbox" value="' . $i . '" name="seats[]">
=======
                            <input type="checkbox" value="' . $i . '" name="seat">
>>>>>>> main
                            <span class="checkmark"></span>
                        </label>
                    </div>';
                }
            }
<<<<<<< HEAD
=======


        }
        if (isset($_POST['choose_seat_regUser'])) {
            $seatId = $_POST['seat'];
            $reservationId = $_SESSION['reservationId'];
            $seatAdd = "UPDATE reservation SET seatId='$seatId' WHERE reservationId='$reservationId'";
            $output = mysqli_query($conn, $seatAdd);
            if (!$output) {
                #echo "Error";
                echo '<script language="javascript">';
                echo "alert('Something wrong.')";
                echo '</script>';
                exit();
            } else {
                echo '<script>
                             if(confirm("Your ticket reserved, successfully.")) {
                                 window.location.href = "finishedReserveTicket_RU.php"
                       }</script>';
                exit();
            }
>>>>>>> main
        }
        }
        }
        }
        ?>
<<<<<<< HEAD
        <br><br><br><br>
        <br><br><br><br><br>
        <div class="cancel_signup">

=======

        <br><br><br><br>
        <br><br><br><br><br>
        <div class="cancel_signup">
>>>>>>> main
            <label class="container_box">
                <input type="checkbox" disabled>
                <span class="checkmark"></span>
                Empty Seat
            </label>

            <label class="container_box">
                <input type="checkbox" checked disabled>
                <span class="checkmark"></span>
                Full Seat
            </label>

<<<<<<< HEAD
            <button type="button" onClick="window.location.href = '../base/homepage_RU.php'" class="returnbtn"
                    style="width:10%">Return
            </button>
            <button type="submit" class="nextbtn" style="background-color: cornflowerblue" name="choose_seat_reserve">
                Next
            </button>

=======
            <button type="button" class="returnbtn" style="background-color: dimgray; width: 15%;"><a
                        href="listOfJourneys_RU.php">Return</a></button>
            <button type="submit" class="nextbtn" style="background-color: cornflowerblue" name="choose_seat_regUser">
                Next
            </button>
>>>>>>> main
        </div>
    </div>
</form>

<br>
<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>


</body>
</html>
