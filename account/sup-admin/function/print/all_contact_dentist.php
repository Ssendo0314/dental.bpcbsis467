<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

$query = "SELECT * FROM `users` WHERE `role` = 'dentist' AND `status` = 'active'";
$result = mysqli_query($conn, $query);

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
    <h2>ALL Contact of The Dentist</h2>
    <p>This all the Account under this Active</p>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Contact No</th>
                <th>Email Address</th>
            </tr>
        </thead>
        <tbody>';

// Populate table rows with user information
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . ' ' . $row['suffixname'] . '</td>
                <td>' . $row['age'] . '</td>
                <td>' . $row['gender'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['contact_no'] . '</td>
                <td>' . $row['email'] . '</td>
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
?>
