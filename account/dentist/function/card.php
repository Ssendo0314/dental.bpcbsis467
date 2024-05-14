<!--Help information-->
<div id="pagesCollapsehow" class="collapse alert alert-info">
    <h3><i class='bx bx-info-circle'></i> How To Use</h3>

</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Appointment History
                <?php
                $history_query = "SELECT * from schedule where user_id ='$id'";
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
                <a class="small text-white stretched-link" href="./apk_history.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Pending Appointment
                <?php
                $history_query = "SELECT * from schedule where user_id ='$id' AND status= 'Waiting'";
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
                <a class="small text-white stretched-link" href="./apk_waiting.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Complete Appointment
                <?php
                $history_query = "SELECT * from schedule where user_id ='$id' AND status= 'Done'";
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
                <a class="small text-white stretched-link" href="./apk_done.php">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Cancelled Appointment
                <?php
                $history_query = "SELECT * from schedule where user_id ='$id' AND status= 'Cancelled'";
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
                <a class="small text-white stretched-link" href="./apk_cancelled.php">View
                    Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>