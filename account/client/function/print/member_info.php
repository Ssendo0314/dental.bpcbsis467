<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Fetch all user information from the database
$id = $_GET['member_id'] ?? null;
if ($id === null) {
  exit ("Error: Member ID not provided.");
}

$query = "SELECT * FROM `members` WHERE member_id='$id'";
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
    <h1><i class="bx bx-add-to-queue"></i>Members Information</h1>
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
while ($member_row = mysqli_fetch_assoc($result)) {
  $html .= '<tr>
                <td>First Name</td>
                <td>' . $member_row['firstname'] . '</td>
              </tr>
              <tr>
                <td>Middle Name</td>
                <td>' . $member_row['middlename'] . '</td>
              </tr>
              <tr>
                <td>Last Name</td>
                <td>' . $member_row['lastname'] . '</td>
              </tr>
              <tr>
                <td>Address</td>
                <td>' . $member_row['address'] . '</td>
              </tr>
              <tr>
                <td>Email</td>
                <td>' . $member_row['email'] . '</td>
              </tr>
              <tr>
                <td>Contact No</td>
                <td>' . $member_row['contact_no'] . '</td>
              </tr>
              <tr>
                <td>Age</td>
                <td>' . $member_row['age'] . '</td>
              </tr>
              <tr>
                <td>Birthday</td>
                <td>' . $member_row['birthday'] . '</td>
              </tr>
              <tr>
                <td>Gender</td>
                <td>' . $member_row['gender'] . '</td>
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
$dompdf->stream("user_information.pdf", array("Attachment" => false));
?>