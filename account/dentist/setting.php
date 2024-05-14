<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Setting - Admin</title>
    <!-- External CSS libraries -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- BoxIcons -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style>

    </style>
</head>

<body class="sb-nav-fixed">
    <?php
    //Profile show
    $list_query = "SELECT * FROM `users` WHERE user_id = {$row['user_id']}";
    $result = mysqli_query($conn, $list_query);
    while ($user_row = mysqli_fetch_array($result)) {
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="main-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                    <!-- /Breadcrumb -->

                    <div class="row gutters-sm">
                        <div class="col-md-4 d-none d-md-block">
                            <div class="card">
                                <div class="card-body">
                                    <nav class="nav flex-column nav-pills nav-gap-y-1">
                                        <a href="javascript:void(0);" onclick="window.history.back();"
                                            class="nav-item nav-link has-icon nav-link-faded">Go Back</a>
                                        <a href="#profile" data-toggle="tab"
                                            class="nav-item nav-link has-icon nav-link-faded active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user mr-2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>Profile Information
                                        </a>
                                        <a href="#account" data-toggle="tab"
                                            class="nav-item nav-link has-icon nav-link-faded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-settings mr-2">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path
                                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                </path>
                                            </svg>Account Settings
                                        </a>
                                        <a href="#security" data-toggle="tab"
                                            class="nav-item nav-link has-icon nav-link-faded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shield mr-2">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            </svg>Security
                                        </a>
                                        <a href="#notification" data-toggle="tab"
                                            class="nav-item nav-link has-icon nav-link-faded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-bell mr-2">
                                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                            </svg>Notification
                                        </a>
                                        <!-- <a href="#billing" data-toggle="tab"
                                        class="nav-item nav-link has-icon nav-link-faded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-credit-card mr-2">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>Billing
                                    </a> -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header border-bottom mb-3 d-flex d-md-none">
                                    <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link has-icon" href="javascript:void(0);"
                                                onclick="window.history.back();">Go Back</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-user">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-settings">
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <path
                                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                    </path>
                                                </svg></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-shield">
                                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                </svg></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#notification" data-toggle="tab" class="nav-link has-icon"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-bell">
                                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                                </svg></a>
                                        </li>
                                        <!-- <li class="nav-item">
                                        <a href="#billing" data-toggle="tab" class="nav-link has-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></a>
                                    </li> -->
                                    </ul>
                                </div>

                                <div class="card-body tab-content">
                                    <!-- Profile -->
                                    <div class="tab-pane active" id="profile">
                                        <h6>YOUR PROFILE INFORMATION</h6>
                                        <hr>
                                        <form class="form" action="./function/update.php" method="post">
                                            <input type="hidden" class="form-control" name="user_id" id="user_id"
                                                value="<?php echo $user_row['user_id']; ?>">
                                            <div class="form-group">
                                                <label class="control-label" for="firstname">
                                                    First Name
                                                </label>
                                                <input type="text" class="form-control" name="firstname" id="firstname"
                                                    aria-describedby="fullNameHelp"
                                                    value="<?php echo $user_row['firstname']; ?>">
                                                <br>
                                                <label class="control-label" for="middlename">
                                                    Middle Name
                                                </label>
                                                <input type="text" class="form-control" name="middlename" id="middlename"
                                                    value="<?php echo $user_row['middlename']; ?>">
                                                <br>
                                                <label class="control-label" for="lastname">
                                                    Last Name
                                                </label>
                                                <input type="text" class="form-control" name="lastname" id="lastname"
                                                    value="<?php echo $user_row['lastname']; ?>">
                                                <br>
                                                <small id="fullNameHelp" class="form-text text-muted">Your name may
                                                    appear around
                                                    here where you are mentioned. You can change or remove it at any
                                                    time.</small>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <label class="control-label" for="address">
                                                        Address</h4>
                                                    </label>
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        value="<?php echo $user_row['address']; ?>">
                                                </div>
                                                <br>
                                                <label class="control-label" for="email">
                                                    Email
                                                </label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    value="<?php echo $user_row['email']; ?>">
                                                <br>
                                                <label class="control-label" for="contact_no">
                                                    Contact Number
                                                </label>
                                                <input type="text" class="form-control" name="contact_no" id="contact_no"
                                                    value="<?php echo $user_row['contact_no']; ?>">
                                                <br>
                                                <div class="col-xs-6">
                                                    <label class="control-label" for="age">
                                                        Age
                                                    </label>
                                                    <input type="text" class="form-control" name="age" id="age"
                                                        value="<?php echo $user_row['age']; ?>" disabled>
                                                </div>
                                                <br>
                                                <label class="control-label" for="birthday">
                                                    Birthday
                                                </label>
                                                <input type="text" class="form-control" name="birthday" id="birthday"
                                                    value="<?php echo $user_row['birthday']; ?>" disabled>
                                                <br>
                                                <label class="control-label" for="gender">
                                                    Gender
                                                </label>
                                                <input type="text" class="form-control" name="gender" id="gender"
                                                    value="<?php echo $user_row['gender']; ?>" disabled>
                                                <br>
                                                <label class="control-label" for="bio">
                                                    Bio
                                                </label>
                                                <?php if (!empty($user_row['bio'])) { ?>
                                                    <textarea class="form-control autosize" name="bio" id="bio"
                                                        placeholder="Write something about you. 500 words only"
                                                        value="<?php echo $user_row['bio']; ?>"
                                                        style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"></textarea>
                                                <?php } else { ?>
                                                    <textarea class="form-control autosize" name="bio" id="bio"
                                                        placeholder="Write something about you. 500 words only"
                                                        style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"></textarea>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group small text-muted">
                                                if you want to change all, please open the <a
                                                    href="./update_profile.php?user_id=<?php echo $user_row['user_id']; ?>"><i
                                                        class='bx bx-add-to-queue'></i>
                                                    Update Profile</a>
                                            </div>
                                            <button class="btn btn-success" type="submit" name="basicinformation"><i
                                                    class="glyphicon glyphicon-ok-sign"></i> Submit</button>
                                        </form>
                                    </div>
                                    <!-- Account -->
                                    <div class="tab-pane" id="account">
                                        <h6>ACCOUNT SETTINGS</h6>
                                        <hr>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username"
                                                aria-describedby="usernameHelp" placeholder="Enter your username"
                                                value="<?php echo $user_row['username']; ?>" disabled>
                                            <!-- <small id="usernameHelp" class="form-text text-muted">After changing
                                                your username,
                                                your old username becomes available for anyone else to
                                                claim.</small> -->
                                        </div>
                                        <hr>
                                        <form action="./function/update.php" method="GET">
                                            <div class="form-group">
                                                <label class="d-block text-danger">Deactivate Account</label>
                                                <p class="text-muted font-size-sm">Once you deactivate your account, there
                                                    is no going
                                                    back. Please be certain.</p>
                                            </div>

                                            <input type="hidden" name="user_id" value="<?php echo $user_row['user_id']; ?>">
                                            <input type="hidden" name="status" value="not active">
                                            <button type="submit" class="btn btn-danger"
                                                name="update_deactivate_staff_yourAccount"
                                                onclick="return confirm('Are you sure you want to deactivate your account?')"
                                                class="btn btn-danger">Deactivate Account</button>
                                        </form>
                                    </div>
                                    <!-- Security -->
                                    <div class="tab-pane" id="security">
                                        <h6>SECURITY SETTINGS</h6>
                                        <hr>
                                        <form>
                                            <div class="form-group">
                                                <label class="d-block" aria-describedby="ChangePassword">Change
                                                    Password</label>
                                                <small id="ChangePassword" class="form-text text-muted">After changing
                                                    to change your password, please open the <a
                                                        href="./update_profile.php?user_id=<?php echo $user_row['user_id']; ?>"><i
                                                            class='bx bx-add-to-queue'></i>
                                                        Update Profile</a></small>
                                            </div>
                                        </form>
                                        <!-- <hr>
                                        <form>
                                            <div class="form-group">
                                                <label class="d-block">Two Factor Authentication</label>
                                                <button class="btn btn-info" type="button">Enable two-factor
                                                    authentication</button>
                                                <p class="small text-muted mt-2">Two-factor authentication adds an
                                                    additional layer
                                                    of security to your account by requiring more than just a password
                                                    to log in.
                                                </p>
                                            </div>
                                        </form> -->
                                        <hr>
                                        <form>
                                            <div class="form-group mb-0">
                                                <label class="d-block">Sessions</label>
                                                <p class="font-size-sm text-secondary">This is a list of devices that
                                                    have logged
                                                    into your account. Revoke any sessions that you do not recognize.
                                                </p>
                                                <ul class="list-group list-group-sm">
                                                    <?php
                                                    // Can change the action depending on the account type
                                                    $activity_query = "SELECT * FROM activity_logs WHERE user_id = {$row['user_id']} AND action = 'Admin Login' AND DATE(timestamp) = CURDATE() ORDER BY timestamp DESC";
                                                    $activity_result = mysqli_query($conn, $activity_query);
                                                    //while statement
                                                    while ($activity_row = mysqli_fetch_array($activity_result)) {
                                                        ?>
                                                        <li class="list-group-item has-icon">
                                                            <div>
                                                                <h6 class="mb-0">
                                                                    <?php echo $activity_row['action'] ?>
                                                                </h6>
                                                                <small class="text-muted">
                                                                    <?php echo $activity_row['description'] ?>
                                                                </small>
                                                            </div>
                                                            <!-- <button class="btn btn-light btn-sm ml-auto" type="button">More
                                                                info</button> -->
                                                            <input type="text" value="<?php echo $activity_row['timestamp'] ?>" disabled />
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Notification -->
                                    <div class="tab-pane" id="notification">
                                        <h6>NOTIFICATION SETTINGS</h6>
                                        <hr>
                                        <small class="form-text text-muted">The NOTIFICATION SETTINGS is still on
                                            process</small>
                                    </div>
                                    <!-- Billing -->
                                    <!-- <div class="tab-pane" id="billing">
                                    <h6>BILLING SETTINGS</h6>
                                    <hr>
                                    <form>
                                        <div class="form-group">
                                            <label class="d-block mb-0">Payment Method</label>
                                            <div class="small text-muted mb-3">You have not added a payment method
                                            </div>
                                            <button class="btn btn-info" type="button">Add Payment Method</button>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="d-block">Payment History</label>
                                            <div
                                                class="border border-gray-500 bg-gray-200 p-3 text-center font-size-sm">
                                                You
                                                have not made any payment.</div>
                                        </div>
                                    </form>
                                </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <br>
            <?php include ('./function/footer.php'); ?>
        </div>
    <?php } ?>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS - added -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- Simple DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <!-- Your custom scripts -->
    <script src="../../js/scripts.js"></script>
    <script src="./js/script.js"></script>
    <!-- Chart.js demo scripts -->
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <!-- Simple DataTables demo script -->
    <script src="../../js/datatables-simple-demo.js"></script>

    <!--JS Addition-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="./js/script.js"></script>
</body>

</html>