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

if (isset($_SESSION['email'])){
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <title>VIEW ALL MY TICKETS RU</title>
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

<div class="container">
    <h1>View All Tickets</h1>
    <hr class="hr_main">
    <table id="seats" style="width: 85%">
        <h4 style="color: darkolivegreen">Buy Ticket Tables</h4>
        <tr style="color: darkred">
            <th>PNR</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Time</th>
            <th>Price</th>
            <th>SeatId</th>
            <th>Ticket Type</th>
            <?php
            $query = "SELECT * FROM journey J, ticket T WHERE J.journeyId=T.journeyId AND T.emailaddress='$email' AND T.seatId!='0' ORDER BY J.journeyDate";
            if (isset($conn)) {
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                echo '<style>p{color:red;}</style><p>Warning: Any ticket find !</p>';
            }
            while ($row = mysqli_fetch_array($result)) {
            ?>
        </tr>
        <tr>
            <td><?php echo $row['PNR']; ?></td>
            <td><?php echo $row['DeparturePlace']; ?></td>
            <td><?php echo $row['DestinationPlace']; ?></td>
            <td><?php echo $row['journeyDate']; ?></td>
            <td><?php echo $row['journeyTime']; ?></td>
            <td><?php
                if ($row['ticketType'] == 'Campaign') {
                    $price = $row['price'];
                    if ($row['campaignId'] == 1) {
                        $price = $price - ($price * 0.1);
                        echo $price;
                    } elseif ($row['campaignId'] == 2) {
                        $price = $price - ($price * 0.15);
                        echo $price;
                    } elseif ($row['campaignId'] == 3) {
                        $price = $price - ($price * 0.2);
                        echo $price;
                    } elseif ($row['campaignId'] == 4) {
                        $price = $price - ($price * 0.25);
                        echo $price;
                    }
                } else {
                    $price = $row['price'];
                    echo $price;
                }
                ?></td>
            <td><?php echo $row['seatId']; ?></td>
            <td><?php echo $row['ticketType']; ?></td>
            <td>
                <?php
                if (($row['ticketType'] == 'Campaign')) {
                    echo "<button type='submit' style=\"background-color: darkgray; width: 70%; color: black; font-weight: bolder; border-radius: 20px; font-size: 14px;\" disabled>Disabled Ticket</button>";
                } else {
                    echo "<button type='submit' style=\"background-color: crimson; width: 70%; border-radius: 20px; font-weight: bolder; font-size: 14px;\"><a href='buyTicketCancel.php'>Cancel Ticket</a></button>";
                } ?>

            </td>
            <?php
            }
            ?>
        </tr>

    </table>
    <br>
    <!-- Reserve Tickets -->
    <table id="seats" style="width: 85%">
        <tr style="color: darkred">
            <h4 style="color: darkolivegreen">Reserved Ticket Tables</h4>
            <th>PNR</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Time</th>
            <th>Price</th>
            <th>SeatId</th>
            <th>Ticket Type</th>
            <?php
            $query2 = "SELECT * FROM journey J, reservation R WHERE J.journeyId=R.journeyId AND R.seatId!='0' AND R.emailLUser='$email' ORDER BY J.journeyDate";
            $result2 = mysqli_query($conn, $query2);
            if (mysqli_num_rows($result2) == 0) {
                echo '<style>p{color:red;}</style><p>Warning: Any ticket find !</p>';
            }
            while ($row2 = mysqli_fetch_array($result2)) {
            ?>
        </tr>
        <tr>
            <td><?php echo $row2['reservationId']; ?></td>
            <td><?php echo $row2['DeparturePlace']; ?></td>
            <td><?php echo $row2['DestinationPlace']; ?></td>
            <td><?php echo $row2['journeyDate']; ?></td>
            <td><?php echo $row2['journeyTime']; ?></td>
            <td><?php echo $row2['price']; ?></td>
            <td><?php echo $row2['seatId']; ?></td>
            <td><?php echo $row2['ticketType']; ?></td>
            <td>
                <?php
                if ($row2['ticketType'] == 'Paid') {
                    echo "<button type='submit' style=\"background-color: darkgray; width: 70%; color: black; font-weight: bolder; border-radius: 20px; font-size: 14px;\" disabled>Disabled Ticket</button>";
                } else {
                    echo "<button type='submit' style=\"background-color: crimson; width: 70%; border-radius: 20px; font-weight: bolder; font-size: 14px;\"><a href='reserveTicketCancel.php'>Cancel Ticket</a></button>";
                } ?>
            </td>
            <?php
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