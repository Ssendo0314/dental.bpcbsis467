<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Sanitize member_id
$member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';

// Fetch service done records
$service_done_query = mysqli_query($conn, "SELECT * FROM `service_done`") or die(mysqli_error($conn));

// Start building HTML content
$html = '<!DOCTYPE html>
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
    <h1>Doctor L.B De Guzman Dental Clinic</h1>
    <h2>Treatment Plan</h2>
    <p>This is Treatment Plan that is already done and this is given by the Dentist</p>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Service Offer</th>
                <th>Teeth Number</th>
                <th>Dentist</th>
            </tr>
        </thead>
        <tbody>';

// Populate table rows with user information
while ($service_done_row = mysqli_fetch_array($service_done_query)) {
    // Sanitize other variables if necessary

    // Fetch additional information
    $service_id = $service_done_row['service_id'];
    $sale_id = $service_done_row['sale_id'];
    $schedule01_id = $service_done_row['id'];
    $account_id = $service_done_row['user_id'];

    // Fetch service details
    $service_query = mysqli_query($conn, "SELECT * FROM service WHERE service_id = '$service_id' ") or die(mysqli_error($conn));
    $service01_row = mysqli_fetch_array($service_query);

    // Fetch sale details
    $sale_query = mysqli_query($conn, "SELECT * FROM `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
    $sale_row = mysqli_fetch_array($sale_query);

    // Fetch schedule details
    $schedule01_query = mysqli_query($conn, "SELECT * FROM `schedule` WHERE id = '$schedule01_id'") or die(mysqli_error($conn));
    $schedule01_row = mysqli_fetch_array($schedule01_query);

    // Fetch account details
    $account_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$account_id' ") or die(mysqli_error($conn));
    $account01_row = mysqli_fetch_array($account_query);

    // Add row to HTML
    $html .= '<tr>
                <td>' . $schedule01_row['date'] . '</td>
                <td>' . $service01_row['service_offer'] . '</td>
                <td>' . $service_done_row['teeth_no'] . '</td>
                <td>'. $account01_row['firstname'] . ' ' . $account01_row['lastname'] .'</td>
              </tr>';
}

$html .= '</tbody></table></body></html>';

// Load HTML to Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render PDF (generate PDF)
$dompdf->render();

// Output PDF to browser
$dompdf->stream("user_information.pdf", array("Attachment" => false));

// Close database connection
mysqli_close($conn);
?>
