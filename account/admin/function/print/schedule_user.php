<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// User exists, proceed with generating the table
$user_id = $_GET['user_id'];
$query = "SELECT * FROM `users` WHERE `user_id` = '$user_id' AND `status` = 'active'";
$result = mysqli_query($conn, $query);

// Define the start date (assuming the current week)
$start_date = date('Y-m-d', strtotime('monday this week'));

// Define office hours
$office_hours_start = 8; // 8:00 AM
$office_hours_end = 18; // 6:00 PM

// Start building HTML content for Dompdf
$html_dompdf = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact of The Client - Print View</title>
    <style>
        @media print {
            /* Add print-specific styles here */
            /* Example: Hide navigation and other unnecessary elements */
            nav, footer {
                display: none;
            }
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <h2>The Schedule</h2>
    <p>This the Schedule under this Account and Location</p>';

// Populate table rows with user information for Dompdf
while ($row = mysqli_fetch_assoc($result)) {
    $location_id = $row['location_id'];

    $location_query = mysqli_query($conn, "SELECT * FROM location WHERE location_id = $location_id");
    $location_row = mysqli_fetch_assoc($location_query);

    $html_dompdf .= '<table><tbody>
        <tr>
        <td>Username:</td>
        <td>' . $row['username'] . '</td>
        </tr>
        <tr>
        <td>Name:</td>
        <td>' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . ' ' . $row['suffixname'] . '</td>
        </tr>
        <tr>
        <td>Location:</td>
        <td>' . $location_row['location'] . '</td>
        </tr>
    </tbody></table><br><br>';
}

$html_dompdf .= '<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>Time</th>';
for ($i = 0; $i < 7; $i++) {
    $html_dompdf .= "<th>" . date('l', strtotime('monday this week +' . $i . ' days')) . "</th>"; // Display day name only
}
$html_dompdf .= '</tr>
    </thead>
    <tbody>';

// Generate the time slots for office hours
for ($hour = $office_hours_start; $hour <= $office_hours_end; $hour++) {
    $html_dompdf .= "<tr>";
    $html_dompdf .= "<td>" . sprintf("%02d", $hour) . ":00</td>"; // Time in HH:00 format
    for ($day = 0; $day < 7; $day++) {
        $current_day = date('l', strtotime('monday this week +' . $day . ' days'));
        // Query duty from the database
        $sql = "SELECT * FROM duty 
            WHERE (duty_day = '$current_day' AND user_id = '$user_id') 
            OR (duty_day LIKE '%$current_day%' AND duty_start_time <= '$hour:00:00' AND duty_end_time > '$hour:00:00')";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $duty_info = "";
            while ($row = $result->fetch_assoc()) {
                if ($row["user_id"] == $user_id) {
                    $account_id = $row["user_id"];
                    /* account query */
                    $account_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$account_id' ") or die(mysqli_error($conn));
                    $account_row = mysqli_fetch_array($account_query);

                    $duty_info .= "<div class='duty-box'>";
                    $duty_info .= "<div class='text-success'>Account: " . $account_row["firstname"] . "</div><br>";
                    $duty_info .= "Role: " . $account_row["role"] . "<br>";
                    $duty_info .= "</div>";
                }
            }
            $html_dompdf .= "<td class='p-1'>$duty_info</td>";
        } else {
            $html_dompdf .= "<td></td>";
        }
    }
    $html_dompdf .= "</tr>";
}

$html_dompdf .= '</tbody></table></body></html>';

// Load HTML to Dompdf
$dompdf->loadHtml($html_dompdf);

// Set paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render PDF (generate PDF)
$dompdf->render();

// Output PDF to browser
$dompdf->stream("user_schedule.pdf", array("Attachment" => false));
?>
