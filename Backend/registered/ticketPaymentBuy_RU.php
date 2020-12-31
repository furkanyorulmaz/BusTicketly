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
    $PNR = $_SESSION['PNR'];
    $email = $_SESSION['email'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">
        <title>TICKET PAYMENT BUY RU</title>
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
        <h1>Ticket Payment</h1>
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
            #echo 'error';
            echo '<script language="javascript">';
            echo "alert('Something connection problem occurs.')";
            echo '</script>';
            exit();
        } else {
            while ($row2 = mysqli_fetch_array($output2)) {
                $price = $row2['price'];
                if (isset($_POST['paymentbutton'])) {
                    $CCNumber = $_POST['CCNumber'];
                    $insertCard = "INSERT INTO payment(CCNumber, balance) VALUES('$CCNumber', 1000.0)";
                    $insertCardConnect = mysqli_query($conn, $insertCard);
                    if (!$insertCardConnect) {
                        #echo "Error";
                        echo '<script> 
                               if(confirm("Wrong Credit Card Number !\nDo you want to continue?")) {
                                    window.location.href = "ticketPaymentBuy_RU.php"
                              }</script>';
                    } else {
                        $ccn = "SELECT * FROM payment WHERE CCNumber='$CCNumber'";
                        $res = mysqli_query($conn, $ccn);
                        if (!$res) {
                            #echo "Wrong Credit Card Number !";
                            echo '<script> 
                               if(confirm("Wrong Credit Card Number !\nDo you want to continue?")) {
                                    window.location.href = "ticketPaymentBuy_RU.php"
                              }</script>';
                        } else {
                            while ($row3 = mysqli_fetch_array($res)) {
                                $balance = $row3['balance'];
                                if ($row3['balance'] < $price) {
                                    #echo "Your balance have not enough money!";
                                    echo '<script> 
                                        if(confirm("Your balance have not enough money !\nDo you want to continue?")) {
                                            window.location.href = "../base/homepage_RU.php"
                                      }</script>';
                                    exit();
                                } else {
                                    $balance -= $price;
                                    $balanceUpdate = "UPDATE payment SET balance='$balance' WHERE CCNumber='$CCNumber'";
                                    $output3 = mysqli_query($conn, $balanceUpdate);
                                    if (!$output3) {
                                        #echo "Error2";
                                        echo '<script> 
                                        if(confirm("Your ticket purchase is not complete !\nDo you want to continue?")) {
                                            window.location.href = "../base/homepage_RU.php"
                                      }</script>';
                                        exit();
                                    } else {
                                        #echo "Payment Finished";
                                        echo '<script> 
                                        if(confirm("Your ticket purchased, successfully.\nDo you want to continue?")) {
                                            window.location.href = "finishedBuyTicket_RU.php"
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



