<div class="card-header">
    <i class="fas fa-table me-1"></i>
    DataTable for List Services
</div>
<div class="card-body">
    <table class="table table-bordered table-hover dt-responsive" id="datatablesSimple">
        <thead>
            <tr>
                <th>Service Offer</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $row['location_id'] is the location_id from the current row
            
            // Construct the SQL query to check if $row['location_id'] exists within the comma-separated list of values in the database
            $check_query = "SELECT COUNT(*) as count FROM `service`";

            // Execute the query to check if the location_id exists
            $check_result = mysqli_query($conn, $check_query);

            if ($check_result) {
                $check_row = mysqli_fetch_assoc($check_result);
                $count = $check_row['count'];

                if ($count > 0) {
                    // $row['location_id'] exists within the comma-separated list of values in the database
                    // Construct the SQL query to select rows based on the condition
                    $service_query = "SELECT * FROM `service` WHERE FIND_IN_SET('" . $location_id . "', `location_id`)";

                    // Execute the query and process the results as needed
                    $service_result = mysqli_query($conn, $service_query);

                    while ($service_row = mysqli_fetch_array($service_result)) {
                        if ($service_row['status'] == "Available") {
                            // Your code to process each row of the result set goes here
                            ?>
                            <tr>
                                <td>
                                <a href="./function/edit_service.php?service_id=<?php echo $service_row['service_id']; ?>" class="text-link"><?php echo $service_row['service_offer']; ?></a>
                                </td>
                                <td> ₱
                                    <?php echo $service_row['price']; ?>
                                </td>
                            </tr>
                        <?php }
                    }
                } else {
                    // $row['location_id'] does not exist within the comma-separated list of values in the database
                    // Handle the case where the location_id is not found
                    echo "Location ID not found in the database.";
                }
            } else {
                // Handle the case where there's an error in the query execution
                echo "Error executing query: " . mysqli_error($conn);
            }
            ?>
        </tbody>
    </table>
</div>