<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access session variables

// Debug: Print session variables
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// database
include('../../../dbcon.php');

//Profile show
if (isset($_SESSION['id'])) {
	$id = $_SESSION['id'];

	$result = mysqli_query ($conn,"Select * from `users` where `user_id`='$id'");
	$row = mysqli_fetch_array ($result);
}

// Include the database connection script
$query = mysqli_query($conn, "SELECT * FROM location") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Navigation</title>
    <style>
        body {
            background-color: #111;
        }

        a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        a:hover {
            color: #f1f1f1;
        }

        /* search */
        #myInput {
            width: 300px;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myUL {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myUL li a {
            margin-top: -1px;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }

        #myUL li a:hover:not(.header) {
            background-color: #eee;
            color: black;
        }
    </style>

</head>

<body>

    <a href="javascript:void(0)" onclick="closeNav_location()">&times;</a>
    <br>
    <h3 style="color:white;"> Select Location </h3>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Location.." title="Type in a name">
    <ul id="myUL">
        <?php while ($location_row = mysqli_fetch_array($query)): ?>
            <li>
                <a href="../apk_cancelled.php?location_id=<?php echo $location_row['location_id']; ?>">
                    <?php echo $location_row['location']; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>


    <script>
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function closeNav_location() {
            window.history.back();
        }
    </script>
</body>

</html>
