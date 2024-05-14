<?php
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
    /* The side navigation menu */
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0; /* Changed from left: 0; */
        background-color: #111;
        overflow-x: hidden;
        padding-top: 60px;
        transition: 0.5s;
    }

    /* The navigation menu links */
    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
        color: #f1f1f1;
    }

    /* Position and style the close button (top right corner) */
    .sidenav .closebtn {
        position: absolute;
        top: 0;
        left: 25px; /* Changed from right: 25px; */
        font-size: 36px;
        margin-right: 50px; /* Changed from margin-left: 50px; */
    }

    /* Style page content */
    #main {
        transition: margin-right .5s; /* Changed from margin-left to margin-right */
        padding: 20px;
    }

    /* On smaller screens */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }

    /* search */
    #myInput {
        width: 100%;
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

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" onclick="closeNav()">&times;</a>
    <h3 style="color:white;"> Select Location </h3>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Location.." title="Type in a name">
    <ul id="myUL">
        <?php while ($row = mysqli_fetch_array($query)): ?>
            <li>
                <a href="./apk_history.php?location_id=<?php echo $row['location_id']; ?>">
                    <?php echo $row['location']; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<!-- Use any element to open the sidenav -->
<!-- <span onclick="openNav()">open</span> -->

<!-- Add all page content inside this div if you want the side nav to push page content to the right
<div id="main">
    ...
</div> -->

<script>
    /* Open the sidenav */
    function openNav() {
        document.getElementById("mySidenav").style.width = "350px";
    }

    /* Close/hide the sidenav */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

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
</script>
</body>
</html>
