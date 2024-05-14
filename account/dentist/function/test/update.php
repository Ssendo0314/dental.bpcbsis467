<?php
session_start();

// Include your database connection file
require_once ('../../../dbcon.php'); ?>

<!-- On Process -->
<?php
if (isset($_GET['schedule_Process'])) {
    // Ensure all required parameters are set
    if (isset($_GET['user_id'], $_GET['id'], $_GET['member_id'], $_GET['status'])) {
        // Retrieve parameters
        $user_id = $_GET['user_id'];
        $id = $_GET['id'];
        $member_id = $_GET['member_id'];
        $newStatus = $_GET['status'];

        // Check if there is an existing schedule on the process
        $existing_query = "SELECT id FROM `schedule` WHERE `user_id`=? AND `member_id`=? AND `status`='Process'";
        $existing_stmt = mysqli_prepare($conn, $existing_query);
        mysqli_stmt_bind_param($existing_stmt, "ii", $user_id, $member_id);
        mysqli_stmt_execute($existing_stmt);
        mysqli_stmt_store_result($existing_stmt);
        $existing_count = mysqli_stmt_num_rows($existing_stmt);
        mysqli_stmt_close($existing_stmt);

        // If there is an existing schedule, exit with a message
        if ($existing_count > 0) {
            $_SESSION['failed'] = "There is already a scheduled activity for this process.";
        }

        // If there is no existing schedule
        if ($existing_count == 0) {
            // Get today's date and time
            $current_date = date("Y-m-d");
            $current_time = date("H:i:s");

            // Now select the timeslot that matches the current time for today
            $timeslot_query = "SELECT timeslot FROM `timeslot` WHERE `time_start` < ? AND `timeslot` NOT IN (SELECT `timeslot` FROM `schedule` WHERE `id` = ?)";
            $timeslot_stmt = mysqli_prepare($conn, $timeslot_query);
            mysqli_stmt_bind_param($timeslot_stmt, "ss", $current_time, $id);
            mysqli_stmt_execute($timeslot_stmt);
            mysqli_stmt_store_result($timeslot_stmt);

            // Now select the next available timeslot for today
            // $timeslot_query = "SELECT timeslot FROM `timeslot` WHERE `time_start` > ? AND `timeslot` NOT IN (SELECT `timeslot` FROM `schedule` WHERE `id` = ?)";
            // $timeslot_stmt = mysqli_prepare($conn, $timeslot_query);
            // mysqli_stmt_bind_param($timeslot_stmt, "ss", $current_time, $id);
            // mysqli_stmt_execute($timeslot_stmt);
            // mysqli_stmt_store_result($timeslot_stmt);

            // If there are available timeslots
            if (mysqli_stmt_num_rows($timeslot_stmt) > 0) {
                mysqli_stmt_bind_result($timeslot_stmt, $timeslot_id);
                mysqli_stmt_fetch($timeslot_stmt);

                // Update schedule with the next available timeslot and current date
                $update_query = "UPDATE `schedule` SET `status`='Process', `timeslot`=?, `date`=? WHERE `id`=?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, "sss", $timeslot_id, $current_date, $id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                $_SESSION['success'] = "Schedule updated successfully with status = Process, date = ' . $current_date . ', and timeslot = ' . $timeslot_id";

                 // Now update all upcoming schedules after the current time
                 $update_upcoming_query = "UPDATE `schedule` SET `status`='Waiting', `timeslot`=(SELECT `timeslot` FROM `timeslot` WHERE `time_start` > ? LIMIT 1), `date`=? WHERE `user_id`=? AND `member_id`=? AND `status` != 'Process' AND `date` > ?";
                 $update_upcoming_stmt = mysqli_prepare($conn, $update_upcoming_query);
                 $current_datetime = date("Y-m-d H:i:s");
                 mysqli_stmt_bind_param($update_upcoming_stmt, "ssis", $current_datetime, $current_date, $user_id, $member_id, $current_date);
                 mysqli_stmt_execute($update_upcoming_stmt);
                 mysqli_stmt_close($update_upcoming_stmt);

            } else {
                // No available timeslots for today
                // Update schedule with the next available timeslot and current date

                // Handle this case accordingly
                $_SESSION['failed'] = "No available timeslots for today";

                // No available timeslots for today, move to the next day with open times available
                //  $next_date = date('Y-m-d', strtotime($current_date . ' +1 day'));

                //  // Now select the timeslot that matches the current time for the next day
                //  $next_day_timeslot_query = "SELECT timeslot FROM `timeslot` WHERE `timeslot` NOT IN (SELECT `timeslot` FROM `schedule` WHERE `date` = ?)";
                //  $next_day_timeslot_stmt = mysqli_prepare($conn, $next_day_timeslot_query);
                //  mysqli_stmt_bind_param($next_day_timeslot_stmt, "s", $next_date);
                //  mysqli_stmt_execute($next_day_timeslot_stmt);
                //  mysqli_stmt_store_result($next_day_timeslot_stmt);

                //  // If there are available timeslots for the next day
                //  if (mysqli_stmt_num_rows($next_day_timeslot_stmt) > 0) {
                //      mysqli_stmt_bind_result($next_day_timeslot_stmt, $next_day_timeslot_id);
                //      mysqli_stmt_fetch($next_day_timeslot_stmt);

                //      // Update schedule with the first available timeslot for the next day
                //      $update_query = "UPDATE `schedule` SET `status`='Process', `timeslot`=?, `date`=? WHERE `id`=?";
                //      $update_stmt = mysqli_prepare($conn, $update_query);
                //      mysqli_stmt_bind_param($update_stmt, "sss", $next_day_timeslot_id, $next_date, $id);
                //      mysqli_stmt_execute($update_stmt);
                //      mysqli_stmt_close($update_stmt);

                //      $_SESSION['success'] = "Schedule updated successfully with status = Process, date = $next_date, and timeslot = $next_day_timeslot_id";
                //  } else {
                //      // No available timeslots for the next day either
                //      exit("No available timeslots for scheduling.");
                //  }
            }

            mysqli_stmt_close($timeslot_stmt);
        }
    }
}
?>

<!-- Redirect to the previous page -->
<script>window.history.back();</script>