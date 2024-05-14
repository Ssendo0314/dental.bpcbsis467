<?php
require_once __DIR__ . '/../../../../vendor/autoload.php'; // Adjust the path to autoload.php based on your project structure
require_once __DIR__ . '/../../../../dbcon.php'; // Adjust the path to dbcon.php based on your project structure

use TCPDF\TCPDF;

// Create new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Title of PDF');
$pdf->SetSubject('Subject of PDF');
$pdf->SetKeywords('Keywords for PDF');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add text
$pdf->Cell(0, 10, 'This is some sample text.', 0, 1);

// Add image
$image_file = 'path_to_your_image.jpg'; // Replace 'path_to_your_image.jpg' with the actual path to your image file
$pdf->Image($image_file, 10, 30, 100, 0, 'JPG', '', '', true, 150);

// Output PDF to browser or file
$pdf->Output('example.pdf', 'D');
?>
