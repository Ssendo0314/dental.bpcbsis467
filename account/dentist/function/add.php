<?php
session_start();

// Include your database connection file
require_once ('../../../dbcon.php');

function processTeethNumbers($existing_teeth_no, $new_teeth_no)
{
    // Combine existing and new teeth numbers
    $combined_teeth_no = $existing_teeth_no . ',' . $new_teeth_no;

    // Split the combined string into an array
    $teeth_no_array = explode(',', $combined_teeth_no);

    // Remove duplicates from the array and convert each element to an integer
    $teeth_no_array = array_unique(array_map('intval', $teeth_no_array));

    // Sort the array numerically
    sort($teeth_no_array);

    // Convert the sorted array back to a comma-separated string
    return implode(',', $teeth_no_array);
}

function processTeethSides($existing_teeth_side, $new_teeth_side)
{
    // Combine existing and new teeth sides
    $combined_teeth_side = $existing_teeth_side . ',' . $new_teeth_side;

    // Split the combined string into an array
    $teeth_side_array = explode(',', $combined_teeth_side);

    // Remove duplicates from the array
    $teeth_side_array = array_unique($teeth_side_array);

    // Define the order of teeth sides
    $order = ['Upper Left', 'Upper Right', 'Lower Left', 'Lower Right'];

    // Sort the teeth sides based on the specified order
    usort($teeth_side_array, function ($a, $b) use ($order) {
        return array_search($a, $order) <=> array_search($b, $order);
    });

    // Convert the sorted array back to a comma-separated string
    return implode(',', $teeth_side_array);
}

function handleTeethNumbers($conn, $service_id, $new_teeth_no, $new_teeth_side, $priority, $id, $user_id, $member_id)
{
    // Fetch existing teeth numbers and sides for the given service_id
    $query = "SELECT `teeth_no`, `teeth_side` FROM `record` WHERE `service_id` = ? AND `done` = ''";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Existing record found
        $row = $result->fetch_assoc();
        $existing_teeth_no = $row['teeth_no'];
        $existing_teeth_side = $row['teeth_side'];

        // Combine existing and new teeth numbers
        $sorted_teeth_no = processTeethNumbers($existing_teeth_no, $new_teeth_no);

        // Combine existing and new teeth sides and sort them based on specified order
        $sorted_teeth_side = processTeethSides($existing_teeth_side, $new_teeth_side);

        // Update the existing record with the sorted teeth numbers and sides
        $update_query = "UPDATE `record` SET `teeth_no` = ?, `teeth_side` = ?, `priority` = ?, `id` = ?, `user_id` = ?, `member_id` = ? WHERE `service_id` = ? AND `done` = ''";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('sssssss', $sorted_teeth_no, $sorted_teeth_side, $priority, $id, $user_id, $member_id, $service_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Updated existing record with combined teeth numbers and sides.";
        } else {
            $_SESSION['failed'] = "Failed to update existing record: " . $conn->error;
        }
    } else {
        // No existing record found, add new teeth numbers and sides
        $insert_query = "INSERT INTO `record` (`service_id`, `teeth_no`, `teeth_side`, `priority`, `id`, `user_id`, `member_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('sssssss', $service_id, $new_teeth_no, $new_teeth_side, $priority, $id, $user_id, $member_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Added new record with teeth numbers and sides.";
        } else {
            $_SESSION['failed'] = "Failed to add new record: " . $conn->error;
        }
    }
}

if (isset($_POST['additional_treatment'])) {
    // Retrieve data from the form
    $service_id = $_POST['service_id'];
    $teeth_no = $_POST['hidden_selected_teeth'];
    $teeth_side = $_POST['hidden_classified_teeth'];
    $priority = $_POST['priority'];
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $member_id = $_POST['member_id'];

    // Handle existing and new teeth numbers and sides
    handleTeethNumbers($conn, $service_id, $teeth_no, $teeth_side, $priority, $id, $user_id, $member_id);
}
?>

<?php
//This is for All
if (isset($_POST['record_done'])) {
    // Get POST data
    $record_id = filter_input(INPUT_POST, 'record_id', FILTER_SANITIZE_NUMBER_INT);
    $service_id = filter_input(INPUT_POST, 'service_id', FILTER_SANITIZE_NUMBER_INT);
    $teeth_no = filter_input(INPUT_POST, 'teeth_no', FILTER_SANITIZE_STRING);
    $tooth_side = filter_input(INPUT_POST, 'teeth_side', FILTER_SANITIZE_STRING);
    $schedule_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $member_id = filter_input(INPUT_POST, 'member_id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

    // Connect to the database (assuming you have a function to do this)
    // Replace this with your function to connect to the database

    if ($conn) {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Check if a record with the given schedule ID exists in the `service_done` table
            $stmt = $conn->prepare("SELECT * FROM service_done WHERE id = ?");
            $stmt->bind_param('i', $schedule_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Record exists, update the existing record in the `service_done` table
                $stmt = $conn->prepare("UPDATE service_done SET service_id = ?, teeth_no = ?, teeth_side = ?, member_id = ?, user_id = ? WHERE id = ?");
                $stmt->bind_param('issiii', $service_id, $teeth_no, $tooth_side, $member_id, $user_id, $schedule_id);
                $stmt->execute();
            } else {
                // Record does not exist, insert a new record into the `service_done` table
                $stmt = $conn->prepare("INSERT INTO service_done (service_id, teeth_no, teeth_side, id, member_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('issiii', $service_id, $teeth_no, $tooth_side, $schedule_id, $member_id, $user_id);
                $stmt->execute();
            }

            // Delete the record from another table (using both `schedule_id` and `record_id`)
            $delete_stmt = $conn->prepare("DELETE FROM record WHERE id = ? AND record_id = ?");
            $delete_stmt->bind_param('ii', $schedule_id, $record_id);
            $delete_stmt->execute();

            // Log the activity in `activity_log` table (assuming you have this table)
            $log_stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, description, timestamp) VALUES (?, ?, ?, NOW())");
            $action = "Updated/Add New Record Done";
            $description = "Updated or inserted";
            $log_stmt->bind_param('iss', $user_id, $action, $description);
            $log_stmt->execute();

            // Commit the transaction
            $conn->commit();

            echo "Service_done updated/inserted successfully, record deleted using schedule_id and record_id, and activity logged.";
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "An error occurred: " . $e->getMessage();
        }

        // Clean up
        $stmt->close();
        $delete_stmt->close();
        $log_stmt->close();
    } else {
        // Handle database connection error
        echo "Failed to connect to the database.";
    }
}

// This for One
if (isset($_POST['record_done_one'])) {
    // Define the order of `teeth_side`
    $teeth_side_order = ['Upper Left', 'Upper Right', 'Lower Left', 'Lower Right'];

    // Create a mapping for the order of `teeth_side`
    $teeth_side_order_map = array_flip($teeth_side_order);

    // Function to sort `teeth_side` array based on the specified order
    function sort_teeth_side($teeth_side, $order_map)
    {
        usort($teeth_side, function ($a, $b) use ($order_map) {
            return $order_map[$a] <=> $order_map[$b];
        });
        return $teeth_side;
    }

    if (isset($_POST['record_id'], $_POST['service_id'], $_POST['teeth_no'], $_POST['teeth_side'], $_POST['id'], $_POST['sale_id'], $_POST['user_id'], $_POST['member_id'])) {
        // All necessary variables from $_POST are set
        $record_id = $_POST['record_id'];
        $service_id = $_POST['service_id'];
        $teeth_no = $_POST['teeth_no'];
        $teeth_side = $_POST['teeth_side'];
        $schedule_id = $_POST['id']; // 'id' from the form
        $sale_id = $_POST['sale_id'];
        $user_id = $_POST['user_id'];
        $member_id = $_POST['member_id'];

        // Sort the `teeth_side` array based on the specified order
        $teeth_side = sort_teeth_side($teeth_side, $teeth_side_order_map);

        // Convert arrays to comma-separated strings
        $teeth_no_str = implode(',', $teeth_no);
        $teeth_side_str = implode(',', $teeth_side);

        // Check if a record with the given `schedule_id` exists
        $query = "SELECT * FROM service_done WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $schedule_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Schedule exists
            // Check if a record with the given `service_id` exists in `schedule_id`
            $query = "SELECT * FROM service_done WHERE id = ? AND service_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $schedule_id, $service_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $service_record = $result->fetch_assoc();

            if ($service_record) {
                // Record with the specified `service_id` exists in the schedule
                // Combine and update the existing record

                // Combine the `teeth_no` and `teeth_side` from the form with the existing record
                $existing_teeth_no = explode(',', $service_record['teeth_no']);
                $existing_teeth_side = explode(',', $service_record['teeth_side']);

                $combined_teeth_no = array_unique(array_merge($existing_teeth_no, $teeth_no));
                $combined_teeth_side = array_unique(array_merge($existing_teeth_side, $teeth_side));

                // Sort the combined `teeth_side` array based on the specified order
                $combined_teeth_side = sort_teeth_side($combined_teeth_side, $teeth_side_order_map);

                // Convert combined arrays back to comma-separated strings
                $combined_teeth_no_str = implode(',', $combined_teeth_no);
                $combined_teeth_side_str = implode(',', $combined_teeth_side);

                // Update the existing record in the `service_done` table
                $update_query = "UPDATE service_done SET teeth_no = ?, teeth_side = ? WHERE id = ? AND service_id = ?";
                $stmt->prepare($update_query);
                $stmt->bind_param('ssis', $combined_teeth_no_str, $combined_teeth_side_str, $schedule_id, $service_id);
                $stmt->execute();

                if ($stmt->execute()) {
                    echo "update record successfully. <br>";

                    // show $teeth_no_str and $teeth_side_str

                    // Function to get tooth side
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
                            if (in_array($teeth_no_str, $teeth_no_parts)) {
                                echo "Tooth number $teeth_no_str exists in record ID $record_id.";

                                // Find the index of the tooth number in the array
                                $index = array_search($teeth_no_str, $teeth_no_parts);

                                // Determine the tooth side
                                $tooth_side_all = getToothSide($teeth_no_str);

                                // Check if the tooth side matches
                                if ($teeth_side_parts[$index] == $teeth_side_str) {
                                    echo "<br>Tooth side $teeth_side_str exists in record ID $record_id.";

                                    // DELETE the selected teeth side and teeth number
                                    $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')), teeth_side = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_side, ','), ',{$teeth_side_str},', ',')) WHERE record_id = ?";
                                    $delete_stmt = $conn->prepare($delete_sql);
                                    $delete_stmt->bind_param("i", $record_id);

                                    if ($delete_stmt->execute()) {
                                        echo "<br>Teeth side $teeth_side_str and tooth number $teeth_no_str deleted successfully.";
                                    } else {
                                        echo "<br>Error deleting teeth side and tooth number: " . $delete_stmt->error;
                                    }

                                    $delete_stmt->close();
                                } else {
                                    echo "<br>Tooth side does not match. ";

                                    // DELETE the Tooth number only
                                    $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')) WHERE record_id = ?";
                                    $delete_stmt = $conn->prepare($delete_sql);
                                    $delete_stmt->bind_param("i", $record_id);

                                    if ($delete_stmt->execute()) {
                                        echo "<br>Tooth number $teeth_no_str deleted successfully.";
                                    } else {
                                        echo "<br>Error deleting tooth number: " . $delete_stmt->error;
                                    }

                                    $delete_stmt->close();
                                }
                            } else {
                                echo "<br>Tooth number $teeth_no_str does not exist in record ID $record_id.";
                            }
                        } else {
                            echo "<br>No teeth numbers found for the given record ID.";
                        }
                    } else {
                        echo "<br>Error: " . $conn->error;
                    }
                } else {
                    // Handle insertion error if the execution fails
                    echo "Failed to insert update record: " . $stmt->error;
                }
            } else {
                $insert_query = "INSERT INTO service_done (service_id, teeth_no, teeth_side, id, sale_id, user_id, member_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param('issiiii', $service_id, $teeth_no_str, $teeth_side_str, $schedule_id, $sale_id, $user_id, $member_id);

                if ($stmt->execute()) {
                    echo "New record inserted successfully. <br>";

                    // show $teeth_no_str and $teeth_side_str

                    // Function to get tooth side
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
                            if (in_array($teeth_no_str, $teeth_no_parts)) {
                                echo "Tooth number $teeth_no_str exists in record ID $record_id.";

                                // Find the index of the tooth number in the array
                                $index = array_search($teeth_no_str, $teeth_no_parts);

                                // Determine the tooth side
                                $tooth_side_all = getToothSide($teeth_no_str);

                                // Check if the tooth side matches
                                if ($teeth_side_parts[$index] == $teeth_side_str) {
                                    echo "<br>Tooth side $teeth_side_str exists in record ID $record_id.";

                                    // DELETE the selected teeth side and teeth number
                                    $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')), teeth_side = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_side, ','), ',{$teeth_side_str},', ',')) WHERE record_id = ?";
                                    $delete_stmt = $conn->prepare($delete_sql);
                                    $delete_stmt->bind_param("i", $record_id);

                                    if ($delete_stmt->execute()) {
                                        echo "<br>Teeth side $teeth_side_str and tooth number $teeth_no_str deleted successfully.";
                                    } else {
                                        echo "<br>Error deleting teeth side and tooth number: " . $delete_stmt->error;
                                    }

                                    $delete_stmt->close();
                                } else {
                                    echo "<br>Tooth side does not match. ";

                                    // DELETE the Tooth number only
                                    $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')) WHERE record_id = ?";
                                    $delete_stmt = $conn->prepare($delete_sql);
                                    $delete_stmt->bind_param("i", $record_id);

                                    if ($delete_stmt->execute()) {
                                        echo "<br>Tooth number $teeth_no_str deleted successfully.";
                                    } else {
                                        echo "<br>Error deleting tooth number: " . $delete_stmt->error;
                                    }

                                    $delete_stmt->close();
                                }
                            } else {
                                echo "<br>Tooth number $teeth_no_str does not exist in record ID $record_id.";
                            }
                        } else {
                            echo "<br>No teeth numbers found for the given record ID.";
                        }
                    } else {
                        echo "<br>Error: " . $conn->error;
                    }
                } else {
                    // Handle insertion error if the execution fails
                    echo "Failed to insert new record: " . $stmt->error;
                }

                // Clean up the statement
                $stmt->close();

            }
        } else {
            // echo "Schedule ID does not exist.";

            //INSERT INTO service_done
            $insert_query = "INSERT INTO service_done (service_id, teeth_no, teeth_side, id, sale_id, user_id, member_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('issiiii', $service_id, $teeth_no_str, $teeth_side_str, $schedule_id, $sale_id, $user_id, $member_id);

            if ($stmt->execute()) {
                echo "New record inserted successfully. <br>";

                // show $teeth_no_str and $teeth_side_str

                // Function to get tooth side
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
                        if (in_array($teeth_no_str, $teeth_no_parts)) {
                            echo "Tooth number $teeth_no_str exists in record ID $record_id.";

                            // Find the index of the tooth number in the array
                            $index = array_search($teeth_no_str, $teeth_no_parts);

                            // Determine the tooth side
                            $tooth_side_all = getToothSide($teeth_no_str);

                            // Check if the tooth side matches
                            if ($teeth_side_parts[$index] == $teeth_side_str) {
                                echo "<br>Tooth side $teeth_side_str exists in record ID $record_id.";

                                // DELETE the selected teeth side and teeth number
                                $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')), teeth_side = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_side, ','), ',{$teeth_side_str},', ',')) WHERE record_id = ?";
                                $delete_stmt = $conn->prepare($delete_sql);
                                $delete_stmt->bind_param("i", $record_id);

                                if ($delete_stmt->execute()) {
                                    echo "<br>Teeth side $teeth_side_str and tooth number $teeth_no_str deleted successfully.";
                                } else {
                                    echo "<br>Error deleting teeth side and tooth number: " . $delete_stmt->error;
                                }

                                $delete_stmt->close();
                            } else {
                                echo "<br>Tooth side does not match. ";

                                // DELETE the Tooth number only
                                $delete_sql = "UPDATE record SET teeth_no = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', teeth_no, ','), ',{$teeth_no_str},', ',')) WHERE record_id = ?";
                                $delete_stmt = $conn->prepare($delete_sql);
                                $delete_stmt->bind_param("i", $record_id);

                                if ($delete_stmt->execute()) {
                                    echo "<br>Tooth number $teeth_no_str deleted successfully.";
                                } else {
                                    echo "<br>Error deleting tooth number: " . $delete_stmt->error;
                                }

                                $delete_stmt->close();
                            }
                        } else {
                            echo "<br>Tooth number $teeth_no_str does not exist in record ID $record_id.";
                        }
                    } else {
                        echo "<br>No teeth numbers found for the given record ID.";
                    }
                } else {
                    echo "<br>Error: " . $conn->error;
                }
            } else {
                // Handle insertion error if the execution fails
                echo "Failed to insert new record: " . $stmt->error;
            }

            // Clean up the statement
            $stmt->close();

        }
    } else {
        echo "Required POST data is missing.";
    }
}
?>

<?php
if (isset($_POST['add_imaging_tests'])) {
    // Retrieve data from the form
    $service_id = $_POST['service_id'];
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $member_id = $_POST['member_id'];

    $teeth_no = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70";
    $teeth_side = "Upper Left, Upper Right, Lower Left, Lower Right";

    // Perform any necessary validation here

    // Insert data into the database
    // Replace 'record' with your actual table name
    $sql = "INSERT INTO `record` (`service_id`, `teeth_no`, `teeth_side`, `id`, `user_id`, `member_id`) 
    VALUES ('$service_id', '$teeth_no', '$teeth_side', '$id', '$user_id', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


if (isset($_POST['add_x_ray'])) {
    // Retrieve data from the form
    $service_id = $_POST['service_id'];
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $member_id = $_POST['member_id'];

    $teeth_no = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70";
    $teeth_side = "Upper Left, Upper Right, Lower Left, Lower Right";

    // Perform any necessary validation here

    // Insert data into the database
    // Replace 'record' with your actual table name
    $sql = "INSERT INTO `record` (`service_id`, `teeth_no`, `teeth_side`, `id`, `user_id`, `member_id`) 
    VALUES ('$service_id', '$teeth_no', '$teeth_side', '$id', '$user_id', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<?php
// Redirect to the previous page
//echo "<script>window.history.back();</script>";
?>