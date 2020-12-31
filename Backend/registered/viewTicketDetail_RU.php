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
    <title>VIEW RESERVED TICKET DETAIL RU</title>
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

                if (!$queryConn) {
                    echo "Error";
                } else {
                    while ($row = mysqli_fetch_array($queryConn)) {
                        $name = $row['userName'];
                        echo " " . $name;
                    }
                }
            } ?></a>
        <a href="../logout.php">Logout</a>
    </div>
</div>
<?php
if (isset($_POST['pnr'])) {
$pnr = $_POST['pnr'];

$foundTicket = "SELECT * FROM reservation WHERE reservationId='$pnr'";
if (isset($conn)) {
$query = mysqli_query($conn, $foundTicket);

if (!$query) {
    echo '<script language="javascript">';
    echo "alert('Something connection problem occurs.')";
    echo '</script>';
    exit();
} else {
?>

<div class="container">
    <h1>Reserved Ticket Detail</h1>
    <hr class="hr_main">
    <table id="seats" style="width: 85%">
        <tr style="color: darkred">
            <th>PNR</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Time</th>
            <th>Price</th>
            <th>SeatNo</th>
            <th>Buy Ticket Action</th>
        </tr>
        <tr>
            <?php

            if (mysqli_num_rows($query) == 0) {
                echo '<script> 
                if(confirm("There is no results matching your search!\nDo you want to continue?")) {
                 window.location.href = "../base/homepage_RU.php"
                }</script>';
            }

            while ($row = mysqli_fetch_array($query)) {
            $journeyId = $row['journeyId'];
            $seatId = $row['seatId'];

            if ($row['ticketType'] == 'Paid') {
                echo '<script> 
                if(confirm("Ticket Payment Completed !\nDo you want to continue?")) {
                 window.location.href = "../base/homepage_RU.php"
                }</script>';
            }

            if ($row['ticketType'] == 'Cancelled') {
                echo '<script> 
                if(confirm("Ticket cancelled before !\nDo you want to continue?")) {
                 window.location.href = "../base/homepage_RU.php"
                }</script>';
            }

            $foundJourneyInfo = "SELECT * FROM journey WHERE journeyId='$journeyId'";
            $query2 = mysqli_query($conn, $foundJourneyInfo);

            if (!$query2) {
                echo "Error 2";
            } else {
            while ($row2 = mysqli_fetch_array($query2)) {
            $from = $row2['DeparturePlace'];
            $to = $row2['DestinationPlace'];
            $date = $row2['journeyDate'];
            $time = $row2['journeyTime'];
            $price = $row2['price'];
            ?>
            <td><?php echo $pnr ?></td>
            <td><?php echo $from ?></td>
            <td><?php echo $to ?></td>
            <td><?php echo $date ?></td>
            <td><?php echo $time ?></td>
            <td><?php echo $price ?> TL</td>
            <td><?php echo $seatId ?></td>

            <?php
            date_default_timezone_set("Europe/Istanbul");
            $journeyDate = $row2['journeyDate'];

            $start_date = strtotime("today");
            $end_date = strtotime("$journeyDate");
            $diff = ($end_date - $start_date);
            $day = ($diff) / 60 / 60 / 24;

            //bileti seyahate bir gün kala alamaz ($day >=  1) 1 gün kala alabilir
            if ($day > 1) {
                echo '<style>p{color:#3366CC;}</style><p> You can buy ticket !</p>';
                ?>
                <td>
                    <?php echo "<button type='submit' style=\"background-color: deepskyblue; width: 80%; font-size: 18px; border-radius: 20px\"><a href='reservedTicketPayment_RU.php'>Buy Ticket</a></button>"; ?>
                </td>
                <?php
            } else {
                $deletePastTicket = "UPDATE reservation SET isCancelled='1',ticketType='Cancelled',seatId='0' WHERE journeyId='$journeyId' AND reservationId='$pnr'";
                $deleted = mysqli_query($conn, $deletePastTicket);
                if (!$deleted) {
                    echo "Error";
                } else {
                    echo '<style>p{color:red;}</style><p>Warning: Ticket date passed. You cannot buy ticket ! </p>';
                    ?>
                    <td>
                        <?php echo "<button type='submit' disabled style=\"background-color:darkgray; width: 80%; font-size: 18px; border-radius: 20px\">Buy Ticket</button>"; ?>
                    </td>
                    <?php
                }
            }
            ?>
        </tr>
        <?php
        }
        }
        $_SESSION['journeyId'] = $journeyId;
        $_SESSION['reservationId'] = $pnr;
        }
        }
        }
        }
        ?>
        </tr>
    </table>
</div>


<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>

