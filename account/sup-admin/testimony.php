<?php include ('./function/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Testimony - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>

<body class="sb-nav-fixed">
    <!--Top Navbar-->
    <?php include ('./function/navbar.php'); ?>
    <div id="layoutSidenav">
        <!--Nav Sidebar-->
        <?php include ('./function/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Testimony</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item">Page</li>
                        <li class="breadcrumb-item active">Testimony</li>
                    </ol>
                    <!--Message-->
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <button onclick="window.location.href ='testimony.php'" type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['success'];
                            // Unset multiple specific session variables
                            unset($_SESSION['success']); ?>
                        </div>
                    <?php } ?>
                    <!--space-->
                    <?php if (isset($_SESSION['failed'])) { ?>
                        <div class="alert alert-danger">
                            <button onclick="window.location.href ='testimony.php'" type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i
                                        class='bx bx-x-circle'></i></span></button>
                            <?php echo $_SESSION['failed'];
                            // Unset multiple specific session variables
                            unset($_SESSION['success']); ?>
                        </div>
                    <?php } ?>
                    <!--Help information-->
                    <div id="pagesCollapsehow" class="collapse alert alert-info">
                        <h3><i class='bx bx-info-circle'></i> How To Use</h3>
                        <p>
                            <strong>View Testimony Using Table</strong>
                            <li>Access the testimony section of the platform or application you're using.</li>
                            <li>Look for the option to view testimonies, often represented by a table icon or labeled as
                                <strong>"View"</strong>
                            </li>
                            <li>Click or tap on the table icon or the designated link to access the testimonies.</li>
                            <li> Each
                                testimony might include details such as the author's name, date, and the content of the
                                testimony.</li>
                        </p>
                        <p>
                            <strong>Add Testimony</strong>
                            <li>Navigate to the section or page where you can contribute a testimony. This is usually
                                labeled as
                                <strong>"Add Testimony"</strong> or something similar.
                            </li>
                            <li>Click on the <strong>"Add Testimony"</strong> button or link.</li>
                            <li> You'll typically be prompted to fill out a form with information such as your name,
                                email (if
                                required), the testimony content, and possibly other details.
                            </li>
                            <li>
                                Once you've completed the form, submit it by clicking the <strong>"Submit"</strong>
                                button or equivalent.
                            </li>
                        </p>
                        <p>
                            <strong>View Testimony in the Review for Shop:</strong>
                            <li>Visit the <strong>"Review for Shop"</strong> section or page within the platform or
                                application.</li>
                            <li>Here, you'll find all the testimonies that users have submitted for the shop or product.
                            </li>
                            <li>Testimonies are usually displayed in a list format, with each testimony showing relevant
                                details
                                like the author's name, date, and the testimony itself.</li>
                            <li>You can read through the testimonies to get an idea of other users' experiences with the
                                shop or
                                product.</li>
                        </p>
                        <p>To learn more, <a href="../../help.php#testimony" target="_blank">Help Center for Testimony</a>
                        </p>
                    </div>
                    <!--Secondary Nav-->
                    <div class="card mb-4">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <!--Help-->
                            <a class="btn btn-info text-white" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapsehow" aria-expanded="false"
                                aria-controls="pagesCollapsehow"><i class='bx bx-info-circle'></i>
                                How
                                to use</a>
                            <!--add-->
                            <a href="./function/add_testimony.php" class="btn  btn-primary text-white"
                                onclick="openForm()"><i class='bx bx-add-to-queue'></i>
                                Add
                                testimony</a>
                        </div>
                    </div>
                    <br>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable for List testimony
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover dt-responsive" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Testimony</th>
                                        <th>Location</th>
                                        <th>Review Star</th>
                                        <th>Social Media</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Testimony</th>
                                        <th>Location</th>
                                        <th>Review Star</th>
                                        <th>Social Media</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $testimony_query = "SELECT * FROM `testimony`";
                                    $testimony_result = mysqli_query($conn, $testimony_query);
                                    //while statement
                                    while ($testimony_row = mysqli_fetch_array($testimony_result)) {

                                        $location_id = $testimony_row['location_id'];
                                        $location_query = mysqli_query($conn, "SELECT * FROM `location` WHERE `location_id` = '$location_id'");
                                        $location_row = mysqli_fetch_array($location_query);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $testimony_row['firstname']; ?>
                                                <?php echo $testimony_row['lastname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $testimony_row['testimony']; ?>
                                            </td>
                                            <td>
                                                <?php echo $location_row['location']; ?>
                                            </td>
                                            <td>
                                                <?php if ($testimony_row['star'] == 1) { ?>
                                                    <i class='bx bxs-star'></i>
                                                <?php } else if ($testimony_row['star'] == 2) { ?>
                                                        <i class='bx bxs-star'></i> <i class='bx bxs-star'></i>
                                                <?php } else if ($testimony_row['star'] == 3) { ?>
                                                            <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i
                                                                class='bx bxs-star'></i>
                                                <?php } else if ($testimony_row['star'] == 4) { ?>
                                                                <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i
                                                                    class='bx bxs-star'></i> <i class='bx bxs-star'></i>
                                                <?php } else if ($testimony_row['star'] == 5) { ?>
                                                                    <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i
                                                                        class='bx bxs-star'></i> <i class='bx bxs-star'></i><i
                                                                        class='bx bxs-star'></i>
                                                <?php } else {
                                                    echo 'Star rating not available';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $testimony_row['media']; ?>
                                            </td>
                                            <td width="auto">
                                                <!-- View -->
                                                <a class="btn btn-primary text-white"
                                                    href="../../shop_view.php?location_id=<?php echo $location_row['location_id']; ?>"
                                                    target="_blank">View</a>
                                                <!--Update-->
                                                <!-- <a
                                                    href="./function/edit_testimony.php?testimony_id=<?php echo $testimony_row['testimony_id']; ?>"><button
                                                        class="btn  btn-primary text-white" type="submit"
                                                        name="testimony_edit"><i class='bx bxs-edit-alt'></i>
                                                        Edit</button></a> -->
                                                <br><br><!--Delete-->
                                                <!-- <form action="./function/delete.php" method="GET">
                                                    <input type="hidden" name="id"
                                                        value="<?php //echo $testimony_row['testimony_id'];       ?>">input Hidden Value
                                                    <button type="submit" class="btn btn-danger" name="testimony_delete"
                                                        onclick="return confirm('are you sure you want to delete?')"><i
                                                            class='bx bxs-traffic-cone'></i></button>
                                                </form> -->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include ('./function/footer.php'); ?>
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