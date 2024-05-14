<?php include('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Contact Dentist - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>

<body class="sb-nav-fixed">
    <!--Datebase-->
    <?php include('../../dbcon.php'); ?>
    <!--Top Navbar-->
    <?php include('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Deactivate Account</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./contact_admin.php">Dashboard</a></li>
                        <li class="breadcrumb-item">Account</li>
                        <li class="breadcrumb-item">Staff Account</li>
                        <li class="breadcrumb-item active"><a href="./contact_dentist=deactive.php">Deactivate
                                Account</a></li>
                    </ol>
                    <!--Message-->
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='contact_dentist.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['success']; ?>
                        </div>
                        <?php
                        unset($_SESSION['success']);
                    } ?>
                    <!--space-->
                    <?php if (isset($_SESSION['failed'])) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="window.location.href ='contact_dentist.php'"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed']; ?>
                        </div>
                        <?php
                        unset($_SESSION['failed']);
                    } ?>
                    <!--Help information-->
                    <div id="pagesCollapsehow" class="collapse alert alert-info">
                        <h3><i class='bx bx-info-circle'></i> How To Use</h3>
                        1. You can Add New Account for Stuff using the <a class="link" onclick="openForm()"><strong><i
                                    class='bx bx-add-to-queue'></i> Add Staff</strong></a>.
                        <br>
                        2. As an Admin Account, You can <strong>Active</strong> and <strong>Deactivate</strong> the
                        Detist Account using
                        the button.
                        <br>
                        3.You can also sort if you want to see <a class="link"
                            href="./contact_dentist.php"><strong>dentist
                                Account</strong></a>, <a class="link"
                            href="./contact_dentist=active.php"><strong>Active</strong></a> and <a class="link"
                            href="./contact_dentist=deactivate.php"><strong>Deactivate</strong></a>
                        <br>
                        4. You can View the Account Information of your Staff using the <i
                            class="fas fa-table me-1"></i> DataTable for Contact Staff then select the <i
                            class='bx bxs-info-circle'></i> View Button.
                        <br>
                        5. You can now <a class="link" href="./function/download/all_contact_dentist.php"><i
                                class='bx bxs-download'></i> Download All</a> the Data of <a class="link"
                            href="./contact_client.php"><strong>Client Account</strong></a> using the button.
                        <br>
                        6.You can now <a class="Link" href="./function/print/all_contact_dentist.php"><i
                                class='bx bxs-printer'></i> Print All</a> the data of <a class="link"
                            href="./contact_client.php"><strong>Client Account</strong></a> using the button.
                    </div>
                    <div class="card mb-4">
                        <!--Secondary Nav-->
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <!--Help-->
                            <a class="btn btn-info text-white" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapsehow" aria-expanded="false"
                                aria-controls="pagesCollapsehow"><i class='bx bx-info-circle'></i>
                                How
                                to use</a>
                            <a class="btn btn-secondary active text-white" href="./contact_dentist.php">All Contacts</a>
                            <a class="btn btn-success text-white" href="./contact_dentist=active.php">Active</a>
                            <a class="btn btn-danger text-white" href="./contact_dentist=deactivate.php">Deactivate</a>
                            <!--add-->
                            <a class="btn btn-primary  text-white" onclick="openForm()"><i
                                    class='bx bx-add-to-queue'></i> Add
                                Staff</a>
                            <?php include('./function/add_dentist.php'); ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable for Contact Staff
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover dt-responsive" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $user_query = mysqli_query($conn, "SELECT * from users WHERE location_id = {$row['location_id']}") or die(mysqli_error($conn));
                                    while ($user_row = mysqli_fetch_array($user_query)) {
                                        $id = $user_row['user_id'];
                                        $location_id = $user_row['location_id'];

                                        $location_query = mysqli_query($conn, "SELECT * from `location` WHERE location_id = '$location_id'") or die(mysqli_error($conn));
                                        $location_row = mysqli_fetch_array($location_query);

                                        if ($user_row['role'] == "dentist" && $user_row['status'] == "not active") { ?>
                                            <tr class="del<?php echo $id ?>">
                                                <td>
                                                    <?php echo $user_row['username']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $user_row['firstname'] . " " . $user_row['middlename'] . " " . $user_row['lastname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $user_row['role']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $location_row['location']; ?>
                                                </td>
                                                <td>
                                                    <?php if ($user_row['role'] == "dentist") { ?>
                                                        <?php if ($user_row['status'] == "active") { ?>
                                                            <form action="./function/update.php" method="GET">
                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo $user_row['user_id']; ?>">
                                                                <input type="hidden" name="status" value="not active">
                                                                <button type="submit" class="btn bg-success text-white"
                                                                    name="update_deactivate_staff"
                                                                    onclick="return confirm('Are you sure you want to deactivate the account?')">Active</button>
                                                            </form>
                                                        <?php } else if ($user_row['status'] == "not active") { ?>
                                                                <form action="./function/update.php" method="GET">
                                                                    <input type="hidden" name="user_id"
                                                                        value="<?php echo $user_row['user_id']; ?>">
                                                                    <input type="hidden" name="status" value="active">
                                                                    <button type="submit" class="btn bg-danger text-white"
                                                                        name="update_active_staff"
                                                                        onclick="return confirm('Are you sure you want to activate the account?')">Not
                                                                        Active</button>
                                                                </form>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($user_row['status'] == "active") { ?>
                                                            <button type="submit" class="btn bg-success text-white"
                                                                disabled>Active</button>
                                                        <?php } else if ($user_row['status'] == "not active") { ?>
                                                                <button type="submit" class="btn bg-danger text-white" disabled>Not
                                                                    Active</button>
                                                        <?php } else if ($user_row['status'] == "temporary") { ?>
                                                                    <button type="submit" class="btn bg-primary text-white" disabled>Temporary
                                                                        Adden</button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <td width="auto">
                                                    <a
                                                        href="./contact_dentist_view.php?user_id=<?php echo $user_row['user_id']; ?>"><button
                                                            type="submit" name="dentistview" class="btn bg-info text-white"><i
                                                                class='bx bxs-info-circle'></i> VIEW</button></a>
                                                    <?php if ($user_row['role'] == "dentist") { ?>
                                                        <a href="#"><button type="submit" name="dentist_delete"
                                                                class="btn bg-danger text-white"><i
                                                                    class='bx bxs-traffic-cone'></i></button></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <a class="btn btn-primary text-white" href="./function/print/all_contact_dentist.php"><i
                                class='bx bxs-printer'></i> Print All</a>
                        <a class="btn btn-dark text-white" href="./function/download/all_contact_dentist.php"><i
                                class='bx bxs-download'></i> Download All</a>
                    </div>
                </div>
            </main>
            <?php include('./function/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>
</body>

</html>