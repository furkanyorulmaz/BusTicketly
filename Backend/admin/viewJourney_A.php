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

if (isset($_SESSION)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../main.css">

    <title>VIEW JOURNEY</title>
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

<form action="#" method="POST">
    <div class="container">
        <h1>View Journey</h1>
        <hr class="hr_main">

        <table id="seats" style="width: 80%">
            <tr style="color: green">
                <th>Journey Id</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Time</th>
                <th>Price</th>
                <th>Cancel Journey Action</th>

                <!-- Burası Biletlerin listelenmeye basladıgı yer -->
                <?php
                date_default_timezone_set("Europe/Istanbul");

                $query = "SELECT * FROM journey ORDER BY journeyDate";
                if (isset($conn)) {
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_array($result)){
                $today = strtotime("today");
                $journeyDate = $row['journeyDate'];
                $journeyDate = strtotime($journeyDate);
                #Today and future journeys list
                if ($today <= $journeyDate){
                ?>
            </tr>
            <tr>
                <td><?php echo $row['journeyId']; ?></td>
                <td><?php echo $row['DeparturePlace']; ?></td>
                <td><?php echo $row['DestinationPlace']; ?></td>
                <td><?php echo $row['journeyDate']; ?></td>
                <td><?php echo $row['journeyTime']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td>
                    <button style="font-size: 16px; background-color: crimson; width: 60%; border-radius: 20px"
                            name="cancel"><a href="cancelJourney_A.php">Cancel Journey</a></button>
                </td>
            </tr>
            <?php
            $_SESSION['id'] = $row['journeyId'];
            $_SESSION['from'] = $row['DeparturePlace'];
            $_SESSION['to'] = $row['DestinationPlace'];
            $_SESSION['date'] = $row['journeyDate'];
            $_SESSION['time'] = $row['journeyTime'];
            $_SESSION['price'] = $row['price'];
            }
            }
            }
            }
            ?>
            </tr>
        </table>
    </div>
</form>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>