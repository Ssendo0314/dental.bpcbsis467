<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session to access session variables

// Include Composer autoload file
require '../../../../vendor/autoload.php';

// database
include('../../../../dbcon.php');

//Profile show
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $result = mysqli_query($conn, "Select * from `users` where `user_id`='$id'");
    $row = mysqli_fetch_array($result);
}

// Execute your query
$sql = "SELECT * FROM users WHERE `role` = 'admin' AND `location_id` = {$row['location_id']}";
$result = $conn->query($sql);

// Create a new Excel file
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Members');

// Add column headers
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'first Name');
$sheet->setCellValue('C1', 'Last Name');
$sheet->setCellValue('D1', 'Middle Name');
$sheet->setCellValue('E1', 'Suffix Name');
$sheet->setCellValue('F1', 'Address');
$sheet->setCellValue('G1', 'Email');
$sheet->setCellValue('H1', 'Contact Number');
$sheet->setCellValue('I1', 'Age');
$sheet->setCellValue('J1', 'Birthday');
$sheet->setCellValue('K1', 'Gender');

// Fetch and add data to the Excel file
$row = 2;
if ($result->num_rows > 0) {
    while ($row_data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $row_data['user_id']);
        $sheet->setCellValue('B' . $row, $row_data['firstname']);
        $sheet->setCellValue('C' . $row, $row_data['lastname']);
        $sheet->setCellValue('D' . $row, $row_data['middlename']);
        $sheet->setCellValue('E' . $row, $row_data['suffixname']);
        $sheet->setCellValue('F' . $row, $row_data['address']);
        $sheet->setCellValue('G' . $row, $row_data['email']);
        $sheet->setCellValue('H' . $row, $row_data['contact_no']);
        $sheet->setCellValue('I' . $row, $row_data['age']);
        $sheet->setCellValue('J' . $row, $row_data['birthday']);
        $sheet->setCellValue('K' . $row, $row_data['gender']);
        $row++;
    }
}

// Save the Excel file to temporary location
$filename = tempnam(sys_get_temp_dir(), 'members_');
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save($filename);

// Send file as a download attachment
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="admin.xlsx"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
readfile($filename);

// Delete temporary file
unlink($filename);

// Close the database connection
$conn->close();
?>
