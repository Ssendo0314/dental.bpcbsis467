<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Fetch all user information from the database
$id = $_GET['id'] ?? null;
if ($id === null) {
    exit ("Error: ID not provided.");
}

$query = "SELECT * FROM `schedule` WHERE id='$id'";
$result = mysqli_query($conn, $query);

// HTML content
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>';

$html .= '<div class="row">
<div class="col-sm-10">
    <h1><i class="bx bx-add-to-queue"></i>Schedule Information</h1>
</div>
<table>
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>';

// Populate table rows with user information
while ($schedule_row = mysqli_fetch_assoc($result)) {
    $member_id = $schedule_row['member_id'];
    $user_id = $schedule_row['user_id'];
    $service_id = $schedule_row['service_id'];
    $number_id = $schedule_row['timeslot'];
    $location_id = $schedule_row['location_id'];

    // MEMBER ACCOUNT
    $member_query = mysqli_query($conn, "SELECT * FROM `members` WHERE `member_id` = '$member_id'") or die (mysqli_error($conn));
    $member_row = mysqli_fetch_assoc($member_query);
    // DOCTOR ACCOUNT
    $user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$user_id'") or die (mysqli_error($conn));
    $user_row = mysqli_fetch_assoc($user_query);
    /* Service query */
    $service_query = mysqli_query($conn, "SELECT * FROM `service` WHERE `service_id` = '$service_id'") or die (mysqli_error($conn));
    $service_row = mysqli_fetch_assoc($service_query);
    /* Timeslot query */
    $time_query = mysqli_query($conn, "SELECT * FROM `timeslot` WHERE `timeslot` = '$number_id'") or die (mysqli_error($conn)); // corrected column name to timeslot_id
    $time_row = mysqli_fetch_assoc($time_query);
    // location query
    $location_query = mysqli_query($conn, "SELECT * FROM `location` WHERE `location_id` = '$location_id'") or die (mysqli_error($conn));
    $location_row = mysqli_fetch_assoc($location_query);
    $html .= '<tr>
                <td>Full Name</td>
                <td>' . $member_row['firstname'] . ' ' . $member_row['middlename'] . ' ' . $member_row['lastname'] . '</td>
              </tr>
              <tr>
                <td>Schedule Date</td>
                <td>' . $schedule_row['date'] . '</td>
              </tr>
              <tr>
              <td>Schedule Time</td>
              <td>';

    // Extracting time start and time end from the database
    $time_start = $time_row['time_start'];
    $time_end = $time_row['time_end'];

    // Converting time to AM/PM format
    $time_start_ampm = date("h:i A", strtotime($time_start));
    $time_end_ampm = date("h:i A", strtotime($time_end));

    $html .= $time_start_ampm . " to " . $time_end_ampm . '</td>
          </tr>
          <tr>
          <td>Location</td>
          <td>' . $location_row['location'] . '</td>
        </tr>
        <tr>
        <td>Location Map</td>
        <td>';

    if (!empty ($location_row['map_link'])) { // corrected column name to map_link
        $html .= '<a href="' . htmlspecialchars($location_row['map_link']) . '" target="_blank" class="text-muted">
                ' . $location_row['map'] . '
            </a>';
    } else {
        $html .= '<p>No location provided</p>'; // corrected syntax
    }

    $html .= '</td>
      </tr>
        <tr>
        <td>Service Offer</td>
        <td>' . $service_row['service_offer'] . '</td>
      </tr>
      <tr>
        <td>Full Name of Doctor</td>
        <td> Doc. ' . $user_row['firstname'] . ' ' . $user_row['middlename'] . ' ' . $user_row['lastname'] . '</td>
        </tr>';
}

$html .= '</tbody></table></body></html>';

// Load HTML to Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (generate PDF)
$dompdf->render();

// Output PDF to browser
$dompdf->stream("schedule_information.pdf", array("Attachment" => false));
?>