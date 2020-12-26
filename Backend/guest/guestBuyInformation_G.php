<?php
session_start();
include("../dbconnect.php");

$journeyId = "";
if(isset($_POST['journeyId'])) {
    $_SESSION['journeyId'] = $_POST['journeyId'];
    $journeyId = $_SESSION['journeyId'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <title>GUEST INFORMATION</title>
    <style>
        /* Add padding and center-align text to the container */
        .container-contactUs {
            padding: 60px;
            text-align: center;
        }

        /* The Modal (background) */
        .modal_background_contactUs {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            padding-top: 50px;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Modal Content/Box */
        .modal-content-contactUs {
            background-color: #87bdd8;
            margin: 5% auto 15% auto;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Modal Close Button (x) */
        .close-contactUs {
            position: absolute;
            right: 35px;
            top: 15px;
            font-size: 40px;
            font-weight: bold;
            color: #f1f1f1;
        }

    </style>
</head>
<body>
<!-- Navbar -->
<div class="navbar">

    <!-- Left-aligned links (default) -->
    <a href="../base/homepage_G.php">Homepage</a>
    <a href="../base/aboutUs_G.php">About Us</a>

    <a onclick="document.getElementById('id01').style.display='block'">Contact Us</a>
    <div id="id01" class="modal_background_contactUs">
        <span onclick="document.getElementById('id01').style.display='none'" class="close-contactUs"
              title="Close Modal">×</span>
        <form class="modal-content-contactUs">
            <div class="container-contactUs">
                <h1 style="color: blanchedalmond">You cannot use contact us</h1>
                <p> You must be registered into website</p>
            </div>
        </form>
    </div>

    <a href="../base/support_G.php">Support</a>

    <!-- Right-aligned links -->
    <div class="navbar-right">
        <a href="../login.php">Login</a>
        <a href="../registration.php">Registration</a>
    </div>

</div>

<form action="#" method="POST">
    <div class="container">
        <h1>Guest User Information For Buy Ticket</h1>
        <hr>

        <label><b>Name</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>

        <label><b>Surname</b></label>
        <input type="text" placeholder="Enter Surname" name="surname" required>

        <label><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label><b>Gender</b></label>
        <input type="text" placeholder="Enter F for Female / M for Male" name="gender" required>

        <br><br><br><br>
        <div class="cancel_signup">
            <button type="button" class="cancelbtn" style="width: 10%; border-radius: 40px"><a
                        href="listOfJourneys_G.php">Return</a></button>
            <button type="submit" class="addjourneybtn" name="guest_info">Next</button>
        </div>
    </div>
</form>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

<?php

if (isset($_POST['guest_info'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    $PNR = rand(10000000, 99999999);
    $journeyId = $_SESSION['journeyId'];
    $ticketType = "GuestBuy";
    $regUserTicket = "INSERT INTO ticket(journeyId, name, surname, emailaddress, ticketType, PNR, gender)
                                    VALUES('$journeyId','$name','$surname','$email','$ticketType','$PNR','$gender') ";

    if (isset($conn)) {
        $insertTicketTable = mysqli_query($conn, $regUserTicket);
        if (!$insertTicketTable) {
            echo "SQL error, check your code! ";
        } else {
            $_SESSION['PNR'] = $PNR;
            $_SESSION['journeyId'] = $journeyId;
            echo '<script> window.location.href = "chooseSeatNoBuy_G.php"</script>';
            exit();
        }
    }
}
?>

<script>
    var modal = document.getElementById('id01');
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
