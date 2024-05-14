<?php
// Assuming $id and $conn are defined and initialized before this code block

$schedule_query = "SELECT * FROM `members` WHERE `member_id`= '$id'";
$schedule_result = mysqli_query($conn, $schedule_query);
$schedule_row = mysqli_fetch_assoc($schedule_result);

if (!empty ($schedule_row['question_id'])) {
    // If question_id has a value, display a link to view the profile
    ?>

    <form class="form-horizontal" method="POST">
        <!-- Select Location -->
        <label class="control-label">Select Location</label>
        <select name="location" class="form-select">
            <?php
            // Fetch locations from the database
            $query = mysqli_query($conn, "SELECT * FROM location") or die (mysqli_error($conn));
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <option value="<?php echo $row['location_id']; ?>">
                    <?php echo $row['location']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- Select Date of Appointment -->
        <label class="control-label">Select Date of Appointment</label>
        <div>
            <input class="form-control" type="date" name="date" id="date" class="select">
        </div>

        <!-- Select Time of Appointment -->
        <label class="control-label">Select Time of Appointment</label>
        <select name="timeslot" class="form-select">
            <?php
            // Fetch timeslots from the database
            $query = mysqli_query($conn, "SELECT * FROM timeslot") or die (mysqli_error($conn));
            while ($row1 = mysqli_fetch_array($query)) {
                ?>
                <option value="<?php echo $row1['timeslot']; ?>">
                    <?php
                    // Display time slot in AM/PM format
                    $time_start = $row1['time_start'];
                    $time_end = $row1['time_end'];
                    $time_start_ampm = date("h:i A", strtotime($time_start));
                    $time_end_ampm = date("h:i A", strtotime($time_end));
                    echo $time_start_ampm . " to " . $time_end_ampm;
                    ?>
                </option>
            <?php } ?>
        </select>

        <!-- Select Service -->
        <label class="control-label">Select Service for this Appointment</label>
        <select name="service" class="form-select">
            <?php
            // Fetch available services from the database
            $query = mysqli_query($conn, "SELECT * FROM service WHERE status = 'Available'") or die (mysqli_error($conn));
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <option value="<?php echo $row['service_id']; ?>">
                    <?php echo $row['service_offer']; ?>
                </option>
            <?php } ?>
        </select>

        <br>
        <!-- Submit Button -->
        <button type="submit" name="sub" class="btn btn-info"><i class="icon-check icon-large"></i>&nbsp;Submit</button>
    </form>

    <?php
    // Handle form submission
    if (isset ($_POST['sub'])) {
        $date = $_POST['date'];
        $service = $_POST['service'];
        $timeslot = $_POST['timeslot'];
        $location = $_POST['location'];

        // Check if the selected date and time are available for a dentist at the chosen location
        $query = mysqli_query($conn, "SELECT * FROM schedule WHERE date = '$date' AND timeslot = '$timeslot' AND location_id = '$location' AND member_id = '$id'") or die (mysqli_error($conn));
        $count = mysqli_num_rows($query);
        if ($count > 0) {
            // Date, time, and location already scheduled, display an alert
            echo '<script>alert("You have already scheduled an appointment at this date, time, and location");</script>';
        } else {
            // Assuming you have already established a session and database connection

            // Validate inputs
            $date = mysqli_real_escape_string($conn, $_POST['date']);
            $timeslot = mysqli_real_escape_string($conn, $_POST['timeslot']);
            $service_id = mysqli_real_escape_string($conn, $_POST['service']); // Assuming service id is also passed through POST
            $location = mysqli_real_escape_string($conn, $_POST['location']); // Assuming location is also passed through POST

            if (!strtotime($date)) {
                die ("Invalid date format."); // Error message for invalid date format
            }

            // Function to expand day ranges from the duty table
            function expandDayRangeFromDutyTable($range, $conn)
            {
                $query = mysqli_query($conn, "SELECT duty_day FROM duty WHERE duty_day LIKE '%$range%'");
                $days = [];
                while ($row = mysqli_fetch_assoc($query)) {
                    $days[] = $row['duty_day'];
                }
                return $days;
            }

            // Check if the timeslot exists in the timeslot table
            $query = mysqli_query($conn, "SELECT * FROM timeslot WHERE timeslot = '$timeslot'") or die (mysqli_error($conn));
            $time_row = mysqli_fetch_array($query); // Fetch the timeslot row

            if (!$time_row) {
                die ("Timeslot does not exist."); // Error message for non-existent timeslot
            }

            // Fetch the start and end times from the timeslot row
            $time_start = $time_row['time_start'];
            $time_end = $time_row['time_end'];

            // Check if the timeslot is available in the schedule table
            $schedule_query = mysqli_query($conn, "SELECT * FROM schedule WHERE date = '$date' AND timeslot = '$timeslot'") or die (mysqli_error($conn));

            if (mysqli_num_rows($schedule_query) > 0) {
                $_SESSION['error_message'] = "The timeslot is not available for the selected date."; // Error message for unavailable timeslot
                echo '<script>window.location.href = "dashboard.php";</script>';
                exit(); // Stop further execution
            }

            // Get the day of the week as text
            $dayOfWeek = ucfirst(date('l', strtotime($date)));

            // Date, service, and location are available, proceed with selecting a dentist
            $schedule_query = mysqli_query($conn, "SELECT * FROM duty WHERE duty_day IN ('" . implode("','", expandDayRangeFromDutyTable($dayOfWeek, $conn)) . "') AND location_id = '$location' ORDER BY TIMESTAMPDIFF(MINUTE, duty_start_time, duty_end_time) DESC") or die (mysqli_error($conn));

            $foundDentist = false;

            if (mysqli_num_rows($schedule_query) > 0) {
                while ($schedule_row = mysqli_fetch_array($schedule_query)) {
                    $schedule_id = $schedule_row['duty_id'];
                    $duty_start_time = $schedule_row['duty_start_time'];
                    $duty_end_time = $schedule_row['duty_end_time'];

                    // Check if the timeslot falls within the duty time range
                    if ($time_start >= $duty_start_time && $time_end <= $duty_end_time) {
                        $user_id = $schedule_row['user_id'];

                        // Fetch dentist information based on user_id
                        $dentist_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id' AND role = 'dentist'") or die (mysqli_error($conn));

                        if (mysqli_num_rows($dentist_query) > 0) {
                            // Found a dentist, select and break the loop
                            $dentist_row = mysqli_fetch_array($dentist_query);
                            $_SESSION['dentist_info'] = $dentist_row; // Storing dentist info in session
                            $_SESSION['date'] = $date; // Storing date in session
                            $_SESSION['service'] = $service; // Storing service id in session
                            $_SESSION['timeslot'] = $timeslot; // Storing timeslot in session
                            $_SESSION['location'] = $location; // Storing location in session
                            $foundDentist = true;
                            break;
                        }
                    }
                }
            }

            // Fetch the start and end times from the timeslot row
            $time_query = mysqli_query($conn, "SELECT TIME_FORMAT(time_start, '%h:%i %p') AS start_time, TIME_FORMAT(time_end, '%h:%i %p') AS end_time FROM timeslot WHERE timeslot = '$timeslot'");
            $time_row = mysqli_fetch_assoc($time_query);
            $time_start = $time_row['start_time'];
            $time_end = $time_row['end_time'];

            // Fetch location name
            $location_query = mysqli_query($conn, "SELECT location FROM location WHERE location_id = '$location'");
            $location_row = mysqli_fetch_assoc($location_query);
            $location_name = $location_row['location'];

            if ($foundDentist) {
                // Redirect to another page where the popup will be displayed using JavaScript
                echo '<script>window.location.href = "dashboard.php";</script>';
                exit(); // Stop further execution
            } else {
                // Use the location name, date, timeslot start, and end times in the error message
                $_SESSION['error_message'] = "No dentist is available for the following date: $date, timeslot: $timeslot ($time_start - $time_end), and location: $location_name.";
                echo '<script>window.location.href = "dashboard.php";</script>';
                exit(); // Stop further execution
            }
        }
    }
    ?>

    <script>
        // Get today's date
        var today = new Date().toISOString().split('T')[0];

        // Set the minimum date for the input field to today
        document.getElementById("date").setAttribute("min", today);
    </script>

<?php } else {
    // If question_id is empty, display a form for scheduling appointment
    ?>
    <h5>Complete Your Medical Record for Better Assistance!</h5>
    <p> To make an Appointment. Please proceed on completing your Medical Record</p>
    <a class="btn btn-primary" href="./medical_question.php?member_id=<?php echo $schedule_row['member_id']; ?>">Answer the
        Question</a>
<?php } ?>