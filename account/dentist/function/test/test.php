<?php
session_start();

// Include your database connection file
require_once ('../../../dbcon.php');

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$record_id = "2"; // Assuming you're setting this dynamically
$tooth_no = "2"; // Assuming you're setting this dynamically
$teeth_side = "Upper Left";

// Function to determine tooth side
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

// Using prepared statements to prevent SQL injection
$sql = "SELECT teeth_no, teeth_side FROM record WHERE record_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $record_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful
if ($result) {
    // Fetch the result row
    $record_row = $result->fetch_assoc();

    // Check if there are teeth numbers retrieved
    if ($record_row) {
        // Split the teeth_no value using a delimiter (e.g., a comma)
        $teeth_no_parts = explode(',', $record_row['teeth_no']);

        // Split the teeth_side value using a delimiter (e.g., a comma)
        $teeth_side_parts = explode(',', $record_row['teeth_side']);

        // Check if the desired tooth number is in the retrieved teeth numbers
        if (in_array($tooth_no, $teeth_no_parts)) {

            echo "Tooth number $tooth_no exists in record ID $record_id.";

            // Find the index of the tooth number in the array
            $index = array_search($tooth_no, $teeth_no_parts);

            // Determine the tooth side
            $tooth_side_all = getToothSide($tooth_no);

            // Check if the tooth side matches
            if ($teeth_side_parts[$index] == $teeth_side) {
                echo "<br>Tooth side $teeth_side exists in record ID $record_id.";

                // DELETE the the selected teeth side  and teeth number
                // Check if the tooth side matches
                if ($teeth_side_parts[$index] == $teeth_side) {
                    echo "<br>Tooth side $teeth_side exists in record ID $record_id.";

                    // DELETE the selected teeth side and teeth number
                    // DELETE the selected teeth side and teeth number
                    $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$tooth_no},', ',')) WHERE record_id = ?";
                    $delete_stmt = $conn->prepare($delete_sql);
                    $delete_stmt->bind_param("i", $record_id);

                    if ($delete_stmt->execute()) {
                        echo "<br>Teeth side $teeth_side and tooth number $tooth_no deleted successfully.";
                    } else {
                        echo "<br>Error deleting teeth side and tooth number: " . $delete_stmt->error;
                    }

                    $delete_stmt->close();
                } else {
                    echo "<br>Tooth side does not match. No changes made.";
                }
            } else {
                echo "<br>Tooth side does not match. No changes made.";
            }
        } else {
            echo "<br>Tooth number $tooth_no does not exist in record ID $record_id.";
        }
    } else {
        echo "<br>No teeth numbers found for the given record ID.";
    }
} else {
    echo "<br>Error: " . $conn->error;
}

// Close prepared statement and connection
$stmt->close();
$conn->close();
?>