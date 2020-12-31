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
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">
        <title>REGISTERED RESERVE INFO</title>
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
            <a href="registerUserProfile.php"><?php
                $email = $_SESSION['email'];
                $query = "SELECT * FROM users WHERE emailaddress='$email'";
                if (isset($conn)) {
                    $queryConn = mysqli_query($conn, $query);

                    if (!$queryConn){
                        echo "Error";
                    }else{
                        while($row = mysqli_fetch_array($queryConn)){
                            $name = $row['userName'];
                            echo " ".$name;
                        }
                    }
                } ?></a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <form action="#" method="POST">
        <div class="container">
            <h1>Registered User Information For Reserve Ticket</h1>
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
                            href="listOfJourneys_RU.php">Return</a></button>
                <button type="submit" class="addjourneybtn" name="registered_reserve">Next</button>
            </div>
        </div>
    </form>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

<?php

if (isset($_POST['registered_reserve'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    $reservationId = rand(10000000, 99999999);
    $journeyId = $_SESSION['journeyId'];
    $ticketType = "Reserved";
    #echo $journeyId;
    $regUserTicket = "INSERT INTO reservation(reservationId, journeyId, emaillUser, name, surname, gender,ticketType)
                                    VALUES('$reservationId', '$journeyId','$email','$name','$surname', '$gender','$ticketType') ";
    if (isset($conn)) {
        $insertTicketTable = mysqli_query($conn, $regUserTicket);
        if (!$insertTicketTable) {
            #eger sistemdeki kayıtlı bir email ile yapmassan işlemi burası çalışır
            echo '<script> language="javascript">';
            echo "alert('Something wrong !\n Enter the registered email address.')";
            echo '</script>';
            exit();

        } else {
            #echo "Ticket added";
            $_SESSION['reservationId'] = $reservationId;
            $_SESSION['journeyId'] = $journeyId;
            echo '<script> window.location.href = "chooseSeatNoReserve_RU.php"</script>';
            exit();

        }
    }
}

?>