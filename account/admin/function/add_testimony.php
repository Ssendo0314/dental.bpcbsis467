<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Icon Link-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="./css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="./css/table_design.css">
    <!--Chart-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <title>Add New Service -Admin</title>
    <style>
        :root {
            /*Primary Color*/
            --white: #FFF2D8;
            --lightblue: #9b9ff2;
            --purple: #7b5da6;
            --violet: #614673;
            --pink: #f27ea9;
            --lightpink: #f2acbf;
            --black: black;
            /*Secondary Color*/
            --yellow: #FFDBAA;
            --lightwhite: #FFE4D6;
            --brightpink: #bf3889;
            --darkpink: #8a3a77;
            --crimsonpink: #a42973;
        }
    </style>
</head>

<body>
    <!-- The form -->
    <div class="modal" id="popupForm">
        <div class="modal-dialog">
            <form class="formContainer" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Please Add New Testimony</h4>
                        <button type="button" class="close" onclick="closeForm()">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="firstname">
                            <strong>First Name</strong>
                        </label>
                        <input type="text" class="form-control" id="firstname" placeholder="First Name"
                            name="firstname" required>
                        <label for="lastname">
                            <strong>Last Name</strong>
                        </label>
                        <input type="text" class="form-control" id="lastname" placeholder="Your Service Offer"
                            name="lastname" required>
                        <label for="testimony">
                            <strong>Testimony</strong>
                        </label>
                        <input type="text" class="form-control" id="testimony" placeholder="Testimony..." name="testimony"
                            required>
                        <label for="media">
                            <strong>Social Media</strong>
                        </label>
                        <input type="text" class="form-control" id="media" placeholder="what is the Social Media?"
                            name="media" required>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="testimony_add" class="btn btn-success">Add Testimony</button>
                        <button type="button" class="btn btn-danger" onclick="closeForm()">Close</button>

                        <!--code Add Service-->
                        <?php
                        if (isset($_POST['testimony_add'])) {
                            $firstname = $_POST['firstname'];
                            $lastname = $_POST['lastname'];
                            $testimony = $_POST['testimony'];
                            $media = $_POST['media'];

                            $testimony_query = "INSERT INTO `testimony`( `firstname`, `lastname`, `testimony`, `media`) 
                            VALUES ('$firstname','$lastname','$testimony','$media')";
                            $testimony_result = mysqli_query($conn, $testimony_query);

                            //For successfully added message
                            // if ($testimony_result) {
                            //     $_SESSION['success'] = "Successfully added";
                            //     echo "<script>window.location.href='../service.php'</script>";
                            // } else {
                            //     $_SESSION['failed'] = "Fail to Add Service";
                            //     echo "<script>window.location.href='../service.php'</script>";
                            // }
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openForm() {
            document.getElementById("popupForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("popupForm").style.display = "none";
        }
    </script>
</body>

</html>