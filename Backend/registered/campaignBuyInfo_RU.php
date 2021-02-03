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
<<<<<<< HEAD

$journeyId = $_SESSION['journeyId'];
$number = $_SESSION['number'];

if (isset($_POST['choose_seat_regUser'])) {
$number = $_POST['number'];
$_SESSION['number'] = $number;
$journeyId = $_SESSION['journeyId'];

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <title>REGISTERED CAMPAIGN INFO</title>
    <style>
        input[type=submit] {
            width: 40%;
            background-color: dodgerblue;
            color: snow;
            font-family: "Dubai Medium";
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 20px;
        }

        input[type=submit]:hover {
            background-color: dodgerblue;
        }

        input[type=text], input[type=email] {
            width: 30%;
            padding: 5px;
            margin: 0 0 0 0;
            display: inline-block;
            border: 3px solid #b7d7e8;
            background: #f1f1f1;
            float: left;
        }

        input[type=text]:focus, input[type=email]:focus {
            background-color: #ddd;
            outline: none;
        }

        label {
            float: left;
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
        <a href="registerUserProfile.php"><?php include "registeredUserName.php"; ?></a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<form action="#" method="POST">
    <div class="container">
        <h1>Information For Campaign Ticket</h1>
        <hr>
        <?php for ($i = 0; $i < $number; $i++) { ?>
            <div>
                <label><b>Name: </b></label>
                <input type="text" style="margin-left:35px" placeholder="Enter Name" name="name[]" required><br><br>

                <label><b>Surname: </b></label>
                <input type="text" style="margin-left:5px" placeholder="Enter Surname" name="surname[]"
                       required><br><br>

                <label><b>Email: </b></label>
                <input type="text" style="margin-left:35px" placeholder="Enter Email" name="email[]"
                       required><br><br>

                <label><b>Gender: &nbsp;</b></label>
                <label class="cont" for="male">Male
                    <input type="checkbox" id="male" name="gender[]" value="M" checked>
                    <span class="check"></span></label>

                <label class="cont" for="female"> &nbsp;&nbsp;Female
                    <input type="checkbox" id="female" name="gender[]" value="F">
                    <span class="check"></span></label><br>
            </div>
            <hr><br>
        <?php }
        } ?>

        <div class="cancel_signup">
            <button type="button" onClick="window.location.href = 'campaigns_RU.php'" class="cancelbtn" style="width: 10%; border-radius: 40px">Return</button>
            <button type="submit" class="addjourneybtn" name="regUserCampaign">Next</button>
        </div>
    </div>
</form>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>


<?php

if (isset($_POST['regUserCampaign'])) {
    $seats = $_SESSION['seats'];
    $journeyId = $_SESSION['journeyId'];
=======
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
        <title>CAMPAIGN TICKET USER INFO</title>
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
            <h1>Registered User Information For Buy Ticket</h1>
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
                <button type="submit" class="addjourneybtn" name="campaign_buy">Next</button>
            </div>
        </div>
    </form>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

<?php

if (isset($_POST['campaign_buy'])) {
>>>>>>> main
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
<<<<<<< HEAD
    $ticketType = "Campaign";

    $arrayPNR = [];
    $arr = array();
    for ($k = 0; $k < $number; $k++) {
        $ticket = array($name["$k"], $surname[$k], $email[$k], $gender[$k], $seats[$k]);
        $arr[$k] = $ticket;
    }

    foreach ($arr as $key => $value) {
        $PNR = rand(10000000, 99999999);
        $regUserTicket = "INSERT INTO ticket(journeyId, name, surname, emailaddress, ticketType, PNR,seatId, gender)
                                    VALUES($journeyId,'$value[0]','$value[1]','$value[2]','$ticketType','$PNR',$value[4],'$value[3]') ";
        if (isset($conn)) {

            $insertTicketTable = mysqli_query($conn, $regUserTicket);
            if (!$insertTicketTable) {
                echo "SQL error, check your code! ";
            }
        }
        $arrayPNR[$key] = $PNR;
    }

    $_SESSION['arrayPNR'] = $arrayPNR;
    echo header("Location: campaignTicketPayment_RU.php");
    exit();
}
?>
=======

    $PNR = rand(10000000, 99999999);
    $journeyId = $_SESSION['journeyId'];
    $ticketType = "Campaign";

    $regUserTicket = "INSERT INTO ticket(journeyId,name, surname, emailaddress,ticketType,PNR, gender)
                                    VALUES('$journeyId','$name','$surname','$email','$ticketType','$PNR','$gender')";
    if (isset($conn)) {
        $insertTicketTable = mysqli_query($conn, $regUserTicket);

        if (!$insertTicketTable) {
            #echo "SQL error, check your code! ";
            echo '<script language="javascript">';
            echo "alert('Something wrong.')";
            echo '</script>';
            exit();
        } else {
            #echo "Ticket added";
            $_SESSION['PNR'] = $PNR;
            $_SESSION['journeyId'] = $journeyId;
            echo '<script> window.location.href = "chooseSeatCampaignTicket.php"</script>';
            exit();

        }
    }
}

?>
>>>>>>> main
