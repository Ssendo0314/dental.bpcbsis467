<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="./dashboard.php">Dental Clinic</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Time and Date-->
    <div class="ms-auto me-0 me-md-3 my-2 my-md-0">
        <?php include ('./function/time.php'); ?>
    </div>
    <!-- Navbar Search-->
    <!--<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>-->
    <!-- Notification -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown notifications">
            <a class="nav-link dropdown-toggle" id="notifications" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class='bx bxs-bell' ></i>
                <?php
                $is_read = "ready"; // 0 means unread, change as necessary
                // Fetch the user's notifications from the database using a prepared statement
                $stmt = $conn->prepare("SELECT * FROM notifications where user_id = ? and is_read = ?");
                $stmt->bind_param("ii", $Id, $is_read);
                $stmt->execute();
                $result = $stmt->get_result();
                $notification_total = $result->num_rows;

                if ($notification_total > 0) {
                    echo '<span id="notification-count" class="badge badge-pill badge-danger">' . $notification_total . '</span>';
                }
                ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifications"
                style="max-height: 300px; overflow-y: auto;">
                <?php
                // Iterate through the user's notifications and display them
                // Modify the query to order the notifications by timestamp in descending order
                $notification_query = mysqli_query($conn, "SELECT * FROM notifications ORDER BY timestamp DESC LIMIT 10");
                while ($notification_row = mysqli_fetch_array($notification_query)) {
                    if (!empty($notification_row['notification_id'])) {
                        ?>
                        <li class="dropdown-item alert">
                            <a href="#">
                                <!-- Determine the type of notification -->
                                <?php
                                $type = $notification_row['type']; // Assuming the type column exists in your notifications table
                        
                                // Format the timestamp
                                $timestamp = $notification_row['timestamp'];
                                // Format the timestamp to your desired format, e.g., "April 15, 2024, 2:30 PM"
                                $formatted_timestamp = date("F j, Y, g:i A", strtotime($timestamp));

                                // Display different styles based on notification type
                                if ($type === 'user_id') {
                                    // Notification from user_id
                                    echo '<span class="link-primary">' . $notification_row['title'] . '</span>';
                                    echo '<br><span class="">' . $notification_row['message'] . '</span>';
                                    echo '<br><span class="">' . $formatted_timestamp . '</span>';
                                } else if ($type === 'schedule') {
                                    // Schedule notification
                                    echo '<span class="link-success">' . $notification_row['title'] . '</span>';
                                    echo '<br><span class="">' . $notification_row['message'] . '</span>';
                                    echo '<br><span class="">' . $formatted_timestamp . '</span>';
                                } else {
                                    // Other types of notification
                                    echo '<span class="link-info">' . $notification_row['title'] . '</span>';
                                    echo '<br><span class="">' . $notification_row['message'] . '</span>';
                                    echo '<br><span class="">' . $formatted_timestamp . '</span>';
                                }
                                ?>
                            </a>
                        </li>
                        <?php
                    } else {
                        echo '<li class="dropdown-item alert alert-info">No Notifications Found</li>';
                    }
                }
                ?>
                <!-- Add a View More button -->
                <li>
                    <a href="#" class="dropdown-item text-center view-more-btn" style="font-weight: bold;">
                        View More
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="./setting.php">Settings</a></li>
                <li><a class="dropdown-item" href="./activity.php">Activity Log</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="../../../dental/logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>