<?php
session_start();
#$conn = mysqli_connect("localhost", "root", "", "busdb");
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
    $PNR = $_SESSION['PNR'];
    $email = $_SESSION['email'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">
        <title>CAMPAIGN TICKET PAYMENT RU</title>
    </head>
    <body>


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
        <h1>Ticket Payment For Buy</h1>
        <hr class="hr_main">
        <form action="#" method="POST">
            <label>Credit Card Number :</label>
            <input style="width: 30%" type="text" placeholder="Enter CC Number" name="CCNumber" id="CCNumber" required
                   minlength="5" maxlength="15">
            <button style="width: 10%" type="submit" name="paymentbutton" class="CCNumbers"><a>Apply</a></button>
        </form>
    </div>

    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

    <?php

    $query2 = "SELECT * FROM journey WHERE journeyId='$journeyId'";
    if (isset($conn)) {
        $output2 = mysqli_query($conn, $query2);

        if (!$output2) {
            echo 'error';
        } else {
            while ($row2 = mysqli_fetch_array($output2)) {
                $price = $row2['price'];
                $campaignId = $row2['campaignId'];
                #echo $campaignId." ".$price;

                if ($campaignId > 0) {
                    if ($campaignId == 1) {
                        $price = $price - ($price * 0.1);
                    } elseif ($campaignId == 2) {
                        $price = $price - ($price * 0.15);
                    } elseif ($campaignId == 3) {
                        $price = $price - ($price * 0.2);
                    } elseif ($campaignId == 4) {
                        $price = $price - ($price * 0.25);
                    }
                } else {
                    #echo "No campaign";
                    echo '<script language="javascript">';
                    echo "alert('No Campaign!')";
                    echo '</script>';
                    exit();
                }

                if (isset($_POST['paymentbutton'])) {
                    $CCNumber = $_POST['CCNumber'];
                    $insertCard = "INSERT INTO payment(CCNumber, balance) VALUES('$CCNumber', 1000.0)";
                    $insertCardConnect = mysqli_query($conn, $insertCard);
                    if (!$insertCardConnect) {
                        #echo "Error";
                        echo '<script language="javascript">';
                        echo "alert('Something wrong !')";
                        echo '</script>';
                        exit();
                    } else {
                        $ccn = "SELECT * FROM payment WHERE CCNumber='$CCNumber'";
                        $res = mysqli_query($conn, $ccn);
                        if (!$res) {
                            #echo "Wrong Credit Card Number !";
                            echo '<script language="javascript">';
                            echo "alert('Wrong Credit Card Number !')";
                            echo '</script>';
                            exit();
                        } else {
                            while ($row3 = mysqli_fetch_array($res)) {
                                $balance = $row3['balance'];
                                if ($row3['balance'] < $price) {
                                    #echo "Your balance have not enough money!";
                                    echo '<script language="javascript">';
                                    echo "alert('Your balance have not enough money !')";
                                    echo '</script>';
                                    exit();
                                } else {
                                    $balance -= $price;
                                    $balanceUpdate = "UPDATE payment SET balance='$balance' WHERE CCNumber='$CCNumber'";
                                    $output3 = mysqli_query($conn, $balanceUpdate);
                                    if (!$output3) {
                                        #echo "Error";
                                        echo '<script language="javascript">';
                                        echo "alert('Something connection problem.')";
                                        echo '</script>';
                                        exit();
                                    } else {
                                        #echo "Payment Finished";
                                        echo '<script> 
                                        if(confirm("Your ticket purchased, successfully.\nDo you want to continue?")) {
                                            window.location.href = "finishedCampaignTicket_RU.php"
                                      }</script>';
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

?>



