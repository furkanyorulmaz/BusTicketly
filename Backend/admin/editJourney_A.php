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
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5 maxmum-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../main.css">

        <title>EDIT JOURNEY</title>
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

    <div class="search-container">
        <h1>Search Journey</h1>
        <form action="" method="POST">
            <input style="width: 50%" type="text" placeholder="Enter Journey ID: " name="journey_id">
            <button style="margin-right: 28%" type="submit" class="addjourneybtn" name="find_journey">Find Journey
            </button>
        </form>
    </div>

    <?php
    if (isset($_POST['find_journey'])){
    $id = $_POST['journey_id'];

    $editJourney = "SELECT * FROM journey WHERE journeyId='$id'";
    if (isset($conn)) {
    $result = mysqli_query($conn, $editJourney);


    if (!$result) {
        echo "SQL error, check your query";
    } else {
    while ($row = mysqli_fetch_array($result)) {

    $from = $row['DeparturePlace'];
    $to = $row['DestinationPlace'];
    $date = $row['journeyDate'];
    $time = $row['journeyTime'];
    $price = $row['price'];
    ?>

    <form action="#" method="POST">
        <div class="container">
            <h1>Edit Journey</h1>
            <hr class="hr_main">

            <label><b>Id</b></label>
            <input type="text" placeholder="<?php echo "" . $id ?>" name="id" required>

            <label><b>From</b></label>
            <input type="text" placeholder="<?php echo "" . $from ?>" name="from" disabled>

            <label><b>To</b></label>
            <input type="text" placeholder="<?php echo "" . $to ?>" name="to" disabled>

            <label><b>Date</b></label>
            <br>
            <input type="text" placeholder="<?php echo "" . $date ?>" name="date" required>

            <label><b>Time</b></label>
            <input type="text" placeholder="<?php echo "" . $time ?>" name="time" required>
            <br>
            <label><b>Price</b></label>
            <input type="text" placeholder="<?php echo "" . $price ?>" name="price" required>
            <br>
            <br>
            <button type="submit" class="addjourneybtn" name="add_journey">Save</a></button>
        </div>
        <?php }
        }
        }
        }
        ?>
    </form>


    <br><br><br><br><br>
    <footer class="main_footer">
        <h5 id="footer_text"> All Rights Reserved By BUS TICKETLY. © 2020</h5>
    </footer>

    </body>
    </html>

<?php
if (isset($_POST['add_journey'])) {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];

    $editQuery = "UPDATE journey SET journeyDate='$date', journeyTime='$time', price='$price' WHERE journeyId='$id'";
    if (isset($conn)) {
        $result = mysqli_query($conn, $editQuery);

        if (!$result) {
            #echo "SQL error, check your query";
            echo '<script> 
                     if(confirm("Journey is not edit !")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        } else {
            #echo "Journey edited successfully";
            echo '<script> 
                     if(confirm("Journey edited, successfully.")) {
                               window.location.href = "adminProfile.php"
              }</script>';
            exit();
        }
    }
}

?>