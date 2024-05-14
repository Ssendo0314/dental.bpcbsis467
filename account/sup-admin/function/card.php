<!--Help information-->
<div id="pagesCollapsehow" class="collapse alert alert-info">
    <h3><i class='bx bx-info-circle'></i> How To Use</h3>
    <p>
        <strong>Viewing the DataTable for List of Appointment History</strong>
        <li> Upon accessing the <strong>Appointment History</strong> section, you'll be presented
            with a DataTable
            displaying a list of all your past appointments.
        </li>
        <li> Each row in the table represents a single appointment and includes details such as
            appointment
            date, time, status, and any relevant notes.
        </li>
    </p>
    <p>
        <strong>Sorting Data</strong>
        <li>You can sort the appointment data based on their status.</li>
        <li>The available sorting options typically include:
            <br>
            <ul>
                <li><strong>Waiting:</strong> Appointments that are scheduled but not yet started.
                </li>
                <li><strong>Done:</strong> Appointments that have been successfully completed.</li>
                <li><strong>Cancel:</strong> Appointments that have been cancel, either by the
                    user or the
                    system.</li>
            </ul>
        </li>
    </p>
    <p>
        <strong>Activating and Deactivating Accounts</strong>
        <li>Within the Appointment History feature, there's functionality to activate or deactivate
            user
            accounts.</li>
        <li>When an account is deactivated, it will automatically cancel any pending appointments
            associated with that account.</li>
        <li>This feature is useful for administrators or users who want to temporarily suspend their
            appointment scheduling activity.</li>
    </p>
    <p>
        <strong>Viewing Scheduled Appointments</strong>
        <li>In addition to viewing past appointments, you can also access a section to view
            scheduled
            appointments.</li>
        <li>This section displays all upcoming appointments, providing details such as appointment
            date,
            time, and status.</li>
    </p>
</div>
<div class="row">
<div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">History Appointment
                <?php
                $history_query = "select * from schedule where location_id = '$location_id'";
                $history_query_run = mysqli_query($conn, $history_query);
                if ($history_total = mysqli_num_rows($history_query_run)) { ?>
                    <h4 class="mb-0">
                        <?php echo $history_total ?>
                    </h4>
                <?php } else { ?>
                    <h4 class="mb-0">0</h4>
                <?php } ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link"
                    href="./apk_history.php?location_id=<?php echo $location_row['location_id']; ?>">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Pending Appointment
                <?php
                $pending_query = "select * from schedule where location_id = '$location_id' AND status= 'Waiting'";
                $pending_query_run = mysqli_query($conn, $pending_query);
                if ($pending_total = mysqli_num_rows($pending_query_run)) { ?>
                    <h4 class="mb-0">
                        <?php echo $pending_total ?>
                    </h4>
                <?php } else { ?>
                    <h4 class="mb-0">0</h4>
                <?php } ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link"
                    href="./apk_waiting.php?location_id=<?php echo $location_row['location_id']; ?>">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Complete Appointment
                <?php
                $done_query = "select * from schedule where location_id = '$location_id' AND status= 'Done'";
                $done_query_run = mysqli_query($conn, $done_query);
                if ($done_total = mysqli_num_rows($done_query_run)) { ?>
                    <h4 class="mb-0">
                        <?php echo $done_total ?>
                    </h4>
                <?php } else { ?>
                    <h4 class="mb-0">0</h4>
                <?php } ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link"
                    href="./apk_done.php?location_id=<?php echo $location_row['location_id']; ?>">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Cancel Appointment
                <?php
                $cancelled_query = "select * from schedule where location_id = '$location_id' AND status= 'Cancelled'";
                $cancelled_query_run = mysqli_query($conn, $cancelled_query);
                if ($cancelled_total = mysqli_num_rows($cancelled_query_run)) { ?>
                    <h4 class="mb-0">
                        <?php echo $cancelled_total ?>
                    </h4>
                <?php } else { ?>
                    <h4 class="mb-0">0</h4>
                <?php } ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link"
                    href="./apk_cancelled.php?location_id=<?php echo $location_row['location_id']; ?>">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>