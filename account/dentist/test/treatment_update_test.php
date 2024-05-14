<?php include ('./function/alert.php'); ?>
<input type="hidden" value="<?php echo $row['user_id']; ?>">
<?php
$record_id = $_GET['record_id'];
$sql = "SELECT * FROM record WHERE record_id = $record_id";
$result = $conn->query($sql);

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
}

?>

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
                <main>
                    <!-- Table for Teeth Number and Side -->
                    <div>
                        <?php
                        // Check if there are records
                        if ($result->num_rows > 0) {
                            // Loop through each record and display it in the table
                            while ($record_row = $result->fetch_assoc()) {

                                // Define the variables for id, member_id, and user_id (modify according to your database structure and data retrieval process)
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
                                    <input type="text" name="service_id" value="<?php echo htmlspecialchars($service_id); ?>" />
                                    <input type="text" name="teeth_no[]" value="<?php echo htmlspecialchars($teeth_no); ?>" />
                                    <input type="text" name="teeth_side[]"
                                        value="<?php echo htmlspecialchars($tooth_side); ?>" />

                                    <!-- Add the hidden input fields for id, member_id, and user_id -->
                                    <input type="text" name="id" value="<?php echo htmlspecialchars($schedule_id); ?>" />
                                    <input type="text" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
                                    <input type="text" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>" />

                                    <!-- Done button, set type to 'submit' for form submission -->
                                    <button class="btn btn-success" type="submit" name="record_done">Done</button>
                                </form>

                                <?php
                                // Split the teeth_no value using a delimiter (e.g., a comma)
                                $teeth_no_parts = explode(',', $record_row['teeth_no']);

                                // Display each part of the teeth_no separately
                                foreach ($teeth_no_parts as $teeth_no_part) {
                                    // Trim spaces and convert tooth number to integer
                                    $tooth_number = (int) trim($teeth_no_part);

                                    // Determine the tooth side using the function
                                    $tooth_side = getToothSide($tooth_number);

                                    // Determine if the tooth is permanent or not
                                    $is_permanent = isPermanent($tooth_number);
                                    $tooth_type = $is_permanent ? 'Permanent' : 'Not Permanent';

                                    // Display each tooth in the table
                                    ?>
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
                                                <tr>
                                                    <td>
                                                        <?php echo htmlspecialchars($teeth_no_part); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlspecialchars($tooth_side); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlspecialchars($tooth_type); ?>
                                                    </td> <!-- New column for Permanent/Non-Permanent -->
                                                    <td>
                                                        <!-- Add a Bootstrap "Done" button inside the td -->
                                                    <td>
                                                        <form method="post" action="./function/add.php">
                                                            <input type="text" name="service_id"
                                                                value="<?php echo htmlspecialchars($service_id); ?>" />
                                                            <input type="text" name="teeth_no[]"
                                                                value="<?php echo htmlspecialchars($teeth_no_part); ?>" />
                                                            <input type="text" name="teeth_side[]"
                                                                value="<?php echo htmlspecialchars($tooth_side); ?>" />
                                                            <input type="text" name="tooth_type[]"
                                                                value="<?php echo htmlspecialchars($tooth_type); ?>" />

                                                            <!-- Add the hidden input fields for id, member_id, and user_id -->
                                                            <input type="text" name="id"
                                                                value="<?php echo htmlspecialchars($schedule_id); ?>" />
                                                            <input type="text" name="user_id"
                                                                value="<?php echo htmlspecialchars($user_id); ?>" />
                                                            <input type="text" name="member_id"
                                                                value="<?php echo htmlspecialchars($member_id); ?>" />

                                                            <!-- Done button, set type to 'submit' for form submission -->
                                                            <button class="btn btn-success" type="submit"
                                                                name="record_done">Done</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                        } else {
                            echo "<tr><td colspan='3'>No records found</td></tr>";
                        }
                        ?>
                    </div>
                </main>
            </div>
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

</body>

</html>