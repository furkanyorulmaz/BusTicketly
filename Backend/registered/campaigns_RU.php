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

    <title>CAMPAIGNS LIST RU</title>
    <style>

        h3, p {
            font-family: 'Dubai Medium';
        }

        #campaignId {
            width: 20%;
            background-color: navajowhite;
            font-size: 20px;
            font-family: "Candara";
            font-weight: bold;
            color: black;
        }

        #select {
            width: 14%;
            margin-right: 65%;
            border-radius: 20px;
            font-size: 18px;
            font-weight: bold;
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

<div class="container">
    <h1>All Campaigns</h1>
    <hr class="hr_main">
    <form action="listOfCampaignsTickets.php" method="POST">

        <?php
        #$query = "SELECT campaignId  FROM journey WHERE campaignId > 0;";
        #$output = mysqli_query($conn, $query);
        #if (!$output) {
        #    echo "SQL error, check your query";
        #} else {
        #}
        #$queryCampaign = "SELECT campaignContent FROM campaign WHERE campaignId='$campaignId';";
        #$output = mysqli_query($conn, $query);
        ?>
        <select id="campaignId" name="campaignId">
            <option value="1"> Campaign 1 <?php ?> </option>
            <option value="2"> Campaign 2 <?php ?> </option>
            <option value="3"> Campaign 3 <?php ?> </option>
            <option value="4"> Campaign 4 <?php ?> </option>
        </select>
        <!-- <p>Campaign Content: </p>-->

        <button class="addjourneybtn" id="select" name="select">Select Campaign</button>
        <br><br><br><br><br>
        <?php
        /*Listed all campaigns system*/
        $allCampaigns = "SELECT * FROM campaign";
        if (isset($conn)) {
            $sqlRun = mysqli_query($conn, $allCampaigns);

            if (!$sqlRun) {
                #echo "error";
                echo '<script language="javascript">';
                echo "alert('Something connection problem occurs.')";
                echo '</script>';
                exit();
            } else {
                while ($row = mysqli_fetch_array($sqlRun)) {
                    $id = $row['campaignId'];
                    $content = $row['campaignContent'];
                    ?>
                    <h3 style="color: #f44336">Campaign: <?php echo " " . $id ?></h3>
                    <p style="color: forestgreen">Description: <?php echo " ' " . $content . " ' " ?></p>
                    <hr>
                    <?php
                }
            }
        }
        ?>

    </form>
</div>

<footer class="main_footer">
    <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
</footer>

</body>
</html>
