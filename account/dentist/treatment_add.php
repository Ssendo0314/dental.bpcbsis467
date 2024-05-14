<?php include ('./function/alert.php'); ?>
<input type="hidden" value="<?php echo $row['user_id']; ?>">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Update Treatment Plan</title>
    <!-- Datatables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Tab Swicth -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tab-content {
            display: none;
            /* Hide tab content initially */
        }

        .tab-content.active {
            display: block;
            /* Show tab content when active */
        }

        /* Treatment Start */
        .project-list>tbody>tr>td {
            padding: 12px 8px;
        }

        .project-list>tbody>tr>td .avatar {
            width: 22px;
            border: 1px solid #CCC;
        }

        /* Treatment End */

        .product-grid-style {
            margin-top: -20px
        }

        img {
            max-width: 100%;
            height: auto;
            vertical-align: top;
        }

        .product-grid-style>[class*="col-"] {
            margin-top: 30px
        }

        .product-grid-style .product-img {
            position: relative
        }

        .product-grid-style .product-img img {
            border-radius: 0.25rem
        }

        .product-grid-style .product-details {
            transition: all .3s ease 0s;
            position: relative
        }

        .product-details .product-cart {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999
        }

        .product-details .product-cart>a {
            width: 40px;
            height: 40px;
            justify-content: center;
            align-items: center;
            display: flex;
            color: #292dc2;
            margin-top: 0;
            margin-right: 10px;
            border-radius: 50%;
            visibility: hidden;
            transition: all 0.5s;
            opacity: 0;
            cursor: pointer;
            background-color: #fff
        }

        .product-details .product-cart a:last-child {
            margin-right: 0
        }

        .product-details .product-cart>a:hover {
            background: #292dc2;
            color: #fff
        }

        .product-details:hover .product-cart a {
            transform: translateY(-30px);
            visibility: visible;
            opacity: 1
        }

        .product-grid-style .product-info {
            padding: 15px;
            float: left;
            width: 100%;
            text-align: center;
            font-size: 18px
        }

        .product-grid-style .product-info>a {
            margin-bottom: 5px;
            display: inline-block;
            font-weight: 600;
            font-size: 15px
        }

        .product-grid-style .price {
            font-weight: 600
        }

        .product-grid-style .price .red {
            color: #878787
        }

        .product-list {
            margin-top: -20px
        }

        .product-list>[class*="col-"] {
            margin-top: 30px
        }

        .product-card {
            border: 1px solid rgba(0, 0, 0, 0.075);
            height: 100%
        }

        .product-card .card-img {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0
        }

        .product-card .card-body {
            padding: 2rem
        }

        .product-card .card-body .read-more {
            display: block
        }

        .product-card .card-body .read-more a {
            color: #292dc2;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px
        }

        .product-card .card-body .read-more a:hover {
            color: #282b2d
        }

        .product-card .card-footer:last-child {
            border-radius: 0
        }

        .product-card h3 {
            font-size: 18px;
            line-height: 26px;
            margin-bottom: 12px
        }

        .product-card h3 a {
            color: #282b2d
        }

        .product-card h3 a:hover {
            color: #292dc2
        }

        .product-card .card-footer {
            background: none;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.8rem 2rem;
            font-weight: 600
        }

        .product-card .card-footer a {
            line-height: normal
        }

        .product-card ul {
            margin-bottom: 0;
            padding-bottom: 0
        }

        .product-card .card-footer img {
            max-width: 35px
        }

        .product-card .card-footer ul li {
            display: inline-block;
            color: #999;
            font-size: 14px;
            font-weight: 500;
            margin: 0 10px 0 0
        }

        .product-card .card-footer ul li i {
            color: #292dc2;
            font-size: 16px;
            font-weight: 500;
            margin-right: 5px
        }

        @media screen and (max-width: 767px) {
            .product-card .card-img.bg-img {
                min-height: 250px
            }
        }

        @media screen and (max-width: 575px) {
            .product-card .card-body {
                padding: 1.5rem
            }
        }

        .product-grid-style .price .red {
            color: #878787;
        }

        .line-through {
            text-decoration: line-through;
        }


        .label-offer {
            position: absolute;
            left: 0;
            top: 0;
            height: 25px;
            line-height: 25px;
            display: inline-block;
            padding: 0px 12px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            z-index: 1
        }

        .bg-red {
            background-color: #ed1b24;
        }

        .bg-primary-solid,
        .primary-overlay-solid[data-overlay-dark]:before {
            background: #292dc2;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <hr>
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-10">
                <h1><i class='bx bx-add-to-queue'></i>Update Treatment Plan</h1>
            </div>
            <!--Logo-->
            <div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class=" img-responsive"
                        src="../../picture/Dental_Logo_Dashboard.png"></a></div>
        </div>
        <br>
        <!-- Body -->
        <div class="row">
            <!-- Main Body -->
            <div class="col-xl-8">
                <!-- Message box -->
                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                            onclick="window.location.href ='dashboard.php'"><span aria-hidden="true"><i
                                    class='bx bx-x-circle'></i></span></button>
                        <?php echo $_SESSION['success']; ?>
                    </div>
                    <?php
                    unset($_SESSION['success']);
                } ?>
                <!--space-->
                <?php if (isset($_SESSION['failed'])) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                            onclick="window.location.href ='dashboard.php'"><span aria-hidden="true"><i
                                    class='bx bx-x-circle'></i></span></button>
                        <?php echo $_SESSION['failed']; ?>
                    </div>
                    <?php
                    unset($_SESSION['failed']);
                } ?>
                <br>
                <ul class="nav nav-tabs" id="myTab">
                    <li><a onclick="toggleContentMode('information')">Table of Treatment Plan</a>
                    </li>
                    <li><a onclick="toggleContentMode('add')">Add</a></li>
                </ul>

                <main>
                    <!-- Information -->
                    <div id="information" class="tab-content active">
                        <br><!-- Select all done-->
                        <div>
                            <?php
                            // Check if there are records
                            $record_id = $_GET['record_id'];
                            $sql = "SELECT * FROM record WHERE record_id = $record_id";
                            $result = $conn->query($sql);
                            // Loop through each record and display it in the table
                            while ($record_row = $result->fetch_assoc()) {

                                // Define the variables for id, member_id, and user_id (modify according to your database structure and data retrieval process)
                                $record_id = $record_row['record_id'];
                                $service_id = $record_row['service_id'];
                                $teeth_no = $record_row['teeth_no'];
                                $tooth_side = $record_row['teeth_side'];
                                $schedule_id = $record_row['id'];
                                $member_id = $record_row['member_id'];
                                $user_id = $record_row['user_id'];

                                /* service query  */
                                $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                                $service01_row = mysqli_fetch_array($service_query);

                                ?>

                                <form method="post" action="./function/add.php">
                                    <input type="hidden" name="record_id"
                                        value="<?php echo htmlspecialchars($record_id); ?>" />
                                    <input type="hidden" name="service_id"
                                        value="<?php echo htmlspecialchars($service_id); ?>" />
                                    <input type="hidden" name="teeth_no"
                                        value="<?php echo htmlspecialchars($teeth_no); ?>" />
                                    <input type="hidden" name="teeth_side"
                                        value="<?php echo htmlspecialchars($tooth_side); ?>" />
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($schedule_id); ?>" />
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
                                    <input type="hidden" name="member_id"
                                        value="<?php echo htmlspecialchars($member_id); ?>" />

                                    <!-- Done button, set type to 'submit' for form submission -->
                                    <button class="btn btn-success" type="submit" name="record_done">Select All
                                        Done</button>
                                </form>
                                <!-- Table for Teeth Number and Side -->
                                <?php
                                $record_id = $_GET['record_id'];
                                $record_sql = "SELECT * FROM record WHERE record_id = $record_id";
                                $record_result = $conn->query($record_sql);

                                function getToothSide($tooth_number)
                                {
                                    if ((1 <= $tooth_number && $tooth_number <= 8) || (51 <= $tooth_number && $tooth_number <= 55)) {
                                        return 'Upper Left';
                                    } elseif ((9 <= $tooth_number && $tooth_number <= 16) || (56 <= $tooth_number && $tooth_number <= 60)) {
                                        return 'Upper Right';
                                    } elseif ((17 <= $tooth_number && $tooth_number <= 24) || (61 <= $tooth_number && $tooth_number <= 65)) {
                                        return 'Lower Left';
                                    } elseif ((25 <= $tooth_number && $tooth_number <= 32) || (66 <= $tooth_number && $tooth_number <= 70)) {
                                        return 'Lower Right';
                                    } else {
                                        return 'unknown';
                                    }
                                }
                                function isPermanent($tooth_number)
                                {
                                    // Permanent teeth numbers range from 1 to 32
                                    if (1 <= $tooth_number && $tooth_number <= 32) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                } ?>

                                <div class="table-responsive">
                                    <!-- PROJECT TABLE -->
                                    <table class="table colored-header datatable project-list">
                                        <thead>
                                            <tr>
                                                <th>Teeth Number</th>
                                                <th>Teeth Side</th>
                                                <th>Type of Tooth</th> <!-- New column for Permanent/Non-Permanent -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            // DELETE the selected teeth side and teeth number if teeth_no is not empty
                                            if ($record_result->num_rows > 0) {
                                                // Loop through each record and display it in the table
                                                while ($record01_row = $record_result->fetch_assoc()) {
                                                    // Check if there are records
                                                    // Define the variables for id, member_id, and user_id (modify according to your database structure and data retrieval process)
                                                    $record01_id = $record01_row['record_id'];
                                                    $service01_id = $record01_row['service_id'];
                                                    $teeth01_no = $record01_row['teeth_no'];
                                                    $tooth01_side = $record01_row['teeth_side'];
                                                    $schedule01_id = $record01_row['id'];
                                                    $sale01_id = $record01_row['sale_id'];
                                                    $member01_id = $record01_row['member_id'];
                                                    $user01_id = $record01_row['user_id'];

                                                    if ($record01_row['teeth_no']) {
                                                        ?>

                                                        <!-- Table for Teeth Number and Side -->
                                                        <div>
                                                            <?php
                                                            // Split the teeth_no value using a delimiter (e.g., a comma)
                                                            $teeth_no_parts = explode(',', $record01_row['teeth_no']);

                                                            // Display each part of the teeth_no separately
                                                            foreach ($teeth_no_parts as $teeth_no_part) {
                                                                // Trim spaces and convert tooth number to integer
                                                                $tooth_number = (int) trim($teeth_no_part);

                                                                // Determine the tooth side using the function
                                                                $tooth01_side = getToothSide($tooth_number);

                                                                // Determine if the tooth is permanent or not
                                                                $is_permanent = isPermanent($tooth_number);
                                                                $tooth_type = $is_permanent ? 'Permanent' : 'Not Permanent';

                                                                // Display each tooth in the table
                                                                ?>

                                                                <tr>
                                                                    <td>
                                                                        <?php echo htmlspecialchars($teeth_no_part); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo htmlspecialchars($tooth01_side); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo htmlspecialchars($tooth_type); ?>
                                                                    </td> <!-- New column for Permanent/Non-Permanent -->
                                                                    <td>
                                                                        <!-- Add a Bootstrap "Done" button inside the td -->
                                                                    <td>
                                                                        <form method="post" action="./function/add.php">
                                                                            <input type="hidden" name="record_id"
                                                                                value="<?php echo htmlspecialchars($record_id); ?>" />
                                                                            <input type="hidden" name="service_id"
                                                                                value="<?php echo htmlspecialchars($service01_id); ?>" />
                                                                            <input type="hidden" name="teeth_no[]"
                                                                                value="<?php echo htmlspecialchars($teeth_no_part); ?>" />
                                                                            <input type="hidden" name="teeth_side[]"
                                                                                value="<?php echo htmlspecialchars($tooth01_side); ?>" />
                                                                            <input type="hidden" name="id"
                                                                                value="<?php echo htmlspecialchars($schedule01_id); ?>" />
                                                                            <input type="hidden" name="sale_id"
                                                                                value="<?php echo htmlspecialchars($sale01_id); ?>" />
                                                                            <input type="hidden" name="user_id"
                                                                                value="<?php echo htmlspecialchars($user01_id); ?>" />
                                                                            <input type="hidden" name="member_id"
                                                                                value="<?php echo htmlspecialchars($member01_id); ?>" />

                                                                            <!-- Done button, set type to 'submit' for form submission -->
                                                                            <button class="btn btn-success" type="submit"
                                                                                name="record_done_one">Done</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                            }
                                                            ?>
                                                        <?php } else { ?>
                                                            <div class="alert alert-warning">Add Teeth Number and Teeth Side</div>
                                                        <?php }
                                                }
                                            } else {
                                                echo "<tr><td colspan='3'>No records found</td></tr>";
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- add -->
                        <div id="add" class="tab-content">
                            <br>
                            <h3><strong>Addition Treatment</strong></h3>
                            <form method="post" action="./function/add.php">
                                <input type="text" name="service_id" value="<?php echo $record_row['service_id']; ?>">

                                <!-- Teeth Number and Teeth Side -->
                                <div class="form-group">
                                    <!-- Master checkbox to select or deselect all checkboxes -->
                                    <div>
                                        <label>
                                            <input type="checkbox" id="select-all-checkboxes"
                                                onclick="toggleAllCheckboxes(this)">
                                            Select All
                                        </label>
                                    </div>

                                    <!-- Input text to display selected checkbox values -->
                                    <div>
                                        <label for="selected-teeth">
                                            Selected Teeth:
                                        </label>
                                        <textarea type="text" class="form-control" id="selected-teeth" readonly></textarea>
                                    </div>

                                    <!-- Input text to display classified selected teeth -->
                                    <div>
                                        <label for="classified-teeth">
                                            Classified Selected Teeth:
                                        </label>
                                        <textarea type="text" class="form-control" id="classified-teeth"
                                            readonly></textarea>
                                    </div>

                                    <!-- Hidden inputs to pass selected and classified teeth data in the form -->
                                    <input type="hidden" id="hidden-selected-teeth" name="hidden_selected_teeth" />
                                    <input type="hidden" id="hidden-classified-teeth" name="hidden_classified_teeth" />
                                    <br>
                                    <table id="TeethNumber" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Permanent Teeth Numbers</th>
                                                <th colspan="3">Not Permanent Teeth</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>Upper Left</th>
                                                <th>Upper Right</th>
                                                <th></th>
                                                <th>Upper Left</th>
                                                <th>Upper Right</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1-8</td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for upper left 1-8
                                                    for ($i = 1; $i <= 8; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for upper right 9-16
                                                    for ($i = 9; $i <= 16; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>51-55</td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for upper left not permanent teeth 51-55
                                                    for ($i = 51; $i <= 55; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for upper right not permanent teeth 56-60
                                                    for ($i = 56; $i <= 60; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>17-24</td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for lower left 17-24
                                                    for ($i = 17; $i <= 24; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for lower right 25-32
                                                    for ($i = 25; $i <= 32; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>61-65</td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for lower left not permanent teeth 61-65
                                                    for ($i = 61; $i <= 65; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Loop through each tooth number for lower right not permanent teeth 66-70
                                                    for ($i = 66; $i <= 70; $i++) {
                                                        echo '<div class="checkbox">';
                                                        echo '<label>';
                                                        echo '<input type="checkbox" name="teeth_number[]" value="' . $i . '" onchange="updateSelectedTeeth()">';
                                                        echo 'Tooth ' . $i;
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    // JavaScript function to toggle all checkboxes
                                    function toggleAllCheckboxes(masterCheckbox) {
                                        const checkboxes = document.querySelectorAll('input[name="teeth_number[]"]');
                                        const isChecked = masterCheckbox.checked;
                                        for (const checkbox of checkboxes) {
                                            checkbox.checked = isChecked;
                                        }
                                        updateSelectedTeeth();
                                    }

                                    // JavaScript function to update the input text with selected checkboxes and classify them
                                    function updateSelectedTeeth() {
                                        const selectedTeeth = [];
                                        const categories = {
                                            upperLeft: false,
                                            upperRight: false,
                                            lowerLeft: false,
                                            lowerRight: false,
                                        };
                                        const checkboxes = document.querySelectorAll('input[name="teeth_number[]"]:checked');

                                        for (const checkbox of checkboxes) {
                                            selectedTeeth.push(checkbox.value);

                                            // Classify the tooth based on its value
                                            const toothNumber = parseInt(checkbox.value, 10);
                                            if (toothNumber >= 1 && toothNumber <= 8) {
                                                categories.upperLeft = true;
                                            } else if (toothNumber >= 9 && toothNumber <= 16) {
                                                categories.upperRight = true;
                                            } else if (toothNumber >= 17 && toothNumber <= 24) {
                                                categories.lowerLeft = true;
                                            } else if (toothNumber >= 25 && toothNumber <= 32) {
                                                categories.lowerRight = true;
                                            } else if (toothNumber >= 51 && toothNumber <= 55) {
                                                categories.upperLeft = true;
                                            } else if (toothNumber >= 56 && toothNumber <= 60) {
                                                categories.upperRight = true;
                                            } else if (toothNumber >= 61 && toothNumber <= 65) {
                                                categories.lowerLeft = true;
                                            } else if (toothNumber >= 66 && toothNumber <= 70) {
                                                categories.lowerRight = true;
                                            }
                                        }

                                        // Update the input text element with the selected teeth values
                                        const selectedTeethInput = document.getElementById('selected-teeth');
                                        selectedTeethInput.value = selectedTeeth.join(', ');

                                        // Update the hidden input with the selected teeth values for form submission
                                        const hiddenSelectedTeeth = document.getElementById('hidden-selected-teeth');
                                        hiddenSelectedTeeth.value = selectedTeeth.join(', ');

                                        // Classify and update the classified teeth based on categories
                                        const classifiedTeeth = [];
                                        if (categories.upperLeft) {
                                            classifiedTeeth.push("Upper Left");
                                        }
                                        if (categories.upperRight) {
                                            classifiedTeeth.push("Upper Right");
                                        }
                                        if (categories.lowerLeft) {
                                            classifiedTeeth.push("Lower Left");
                                        }
                                        if (categories.lowerRight) {
                                            classifiedTeeth.push("Lower Right");
                                        }

                                        const classifiedTeethInput = document.getElementById('classified-teeth');
                                        classifiedTeethInput.value = classifiedTeeth.join(', ');

                                        // Update the hidden input with the classified teeth values for form submission
                                        const hiddenClassifiedTeeth = document.getElementById('hidden-classified-teeth');
                                        hiddenClassifiedTeeth.value = classifiedTeeth.join(', ');

                                        // Update the state of the "Select All" checkbox based on the state of individual checkboxes
                                        const allCheckboxes = document.querySelectorAll('input[name="teeth_number[]"]');
                                        const selectAllCheckbox = document.getElementById('select-all-checkboxes');
                                        const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox.checked);
                                        selectAllCheckbox.checked = allChecked;
                                    }
                                </script>

                                <!--Priority -->
                                <div class="form-group">
                                    <label for="priority">Priority</label>
                                    <select class="form-control" id="priority" name="priority">
                                        <option value="High">HIGH</option>
                                        <option value="Mid">MID</option>
                                        <option value="Low">LOW</option>
                                    </select>
                                </div>

                                <!-- Hidden Fields -->
                                <input type="hidden" name="id" id="id" value="<?php echo $record_row['id']; ?>">
                                <input type="hidden" name="user_id" id="user_id"
                                    value="<?php echo $record_row['user_id']; ?>">
                                <input type="hidden" name="member_id" id="member_id"
                                    value="<?php echo $record_row['member_id']; ?>">

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success" name="additional_treatment">Submit</button>
                            </form>
                            <br><br>
                        </div>
                    <?php } ?>
                </main>
            </div>
            <!-- Side -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Service</label>
                            <input type="text" class="form-control"
                                value="<?php echo $service01_row['service_offer']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <br>
                <!-- Appointment Calendar information -->
                <div class="card">
                    <h3 class="text-center"><strong>Schedule Appointment</strong></h3>
                    <?php $schedule_query = mysqli_query($conn, "select * from schedule where id = ' $schedule_id'") or die(mysqli_error($conn));

                    while ($schedule_row = mysqli_fetch_array($schedule_query)) {
                        $id = $schedule_row['id'];
                        $timeslot = $schedule_row['timeslot'];
                        $member_id = $schedule_row['member_id'];
                        $account_id = $schedule_row['user_id'];
                        $service_id = $schedule_row['service_id'];
                        $treatment_id = $schedule_row['record_id'];
                        $question_id = $schedule_row['question_id'];
                        $location_id = $schedule_row['location_id'];

                        // Timeslot Query
                        $timeslot_query = mysqli_query($conn, "select * from timeslot where timeslot = '$timeslot'") or die(mysqli_error($conn));
                        $timeslot_row = mysqli_fetch_array($timeslot_query);
                        /* member query  */
                        $member_query = mysqli_query($conn, "select * from members where member_id = ' $member_id'") or die(mysqli_error($conn));
                        $member_row = mysqli_fetch_array($member_query);
                        /* account query  */
                        $account_query = mysqli_query($conn, "select * from users where user_id = ' $account_id' ") or die(mysqli_error($conn));
                        $account_row = mysqli_fetch_array($account_query);
                        /* service query  */
                        $service_query = mysqli_query($conn, "select * from service where service_id = '$service_id' ") or die(mysqli_error($conn));
                        $service_row = mysqli_fetch_array($service_query);
                        /* treatment query  */
                        $treatment_query = mysqli_query($conn, "select * from record where record_id = '$treatment_id' ") or die(mysqli_error($conn));
                        $treatment_row = mysqli_fetch_array($treatment_query);
                        /* question query  */
                        $question_query = mysqli_query($conn, "select * from survey_responses where question_id = '$question_id' ") or die(mysqli_error($conn));
                        $question_row = mysqli_fetch_array($question_query);
                        // Location Query
                        $location_query = mysqli_query($conn, "select * from location where location_id = '$location_id'") or die(mysqli_error($conn));
                        $location_row = mysqli_fetch_array($location_query);
                        ?>
                        <div class="card-body">
                            <div class="col-xs-12">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" value="<?php echo $schedule_row['date']; ?>"
                                    disabled>
                            </div>
                            <div class="col-xs-12">
                                <?php
                                // Extracting time start and time end from the database
                                $time_start = $timeslot_row['time_start'];
                                $time_end = $timeslot_row['time_end'];

                                // Converting time to AM/PM format
                                $time_start_ampm = date("h:i A", strtotime($time_start));
                                $time_end_ampm = date("h:i A", strtotime($time_end));
                                ?>
                                <label class="form-label">Timeslot</label>
                                <input type="Timeslot" class="form-control"
                                    value="Slot <?php echo $schedule_row['timeslot'] . " (" . $time_start_ampm . " to " . $time_end_ampm ?>)"
                                    disabled>
                            </div>
                            <div class="col-xs-12">
                            </div>
                            <div class="col-xs-12">
                                <label class="form-label">Location Name</label>
                                <input type="text" class="form-control" value="<?php echo $location_row['location']; ?>"
                                    disabled>
                            </div>
                            <div class="col-xs-12">
                                <label class="form-label">Dentist Name</label>
                                <input type="text" class="form-control"
                                    value="Dr. <?php echo $account_row['firstname'] . " " . $account_row['lastname']; ?>"
                                    disabled>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <!-- Tab Swicth -->
    <script>
        function toggleContentMode(tabName) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }

            // Show the selected tab content
            var selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        }

        function toggleTabContent() {
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.toggle('active');
            }
        }
    </script>
</body>

</html>