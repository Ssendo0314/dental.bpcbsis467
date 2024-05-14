<?php
session_start(); // Start session

include ('./dbcon.php');

// Function to log member login activity
function logActivity_member($action, $description, $member_id, $conn)
{
  $timestamp = date("Y-m-d H:i:s");
  $sql = "INSERT INTO activity_logs (action, description, member_id, timestamp) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssis", $action, $description, $member_id, $timestamp);

  if ($stmt->execute()) {
    // Activity logged successfully
  } else {
    // Error logging activity
  }
}

// Function to log admin login activity
function logActivity_admin($action, $description, $user_id, $conn)
{
  $timestamp = date("Y-m-d H:i:s");
  $sql = "INSERT INTO activity_logs (action, description, user_id, timestamp) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssis", $action, $description, $user_id, $timestamp);

  if ($stmt->execute()) {
    // Activity logged successfully
  } else {
    // Error logging activity
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Check the member table
  $members_query = "SELECT * FROM members WHERE username = ? AND password = ?";
  $stmt = $conn->prepare($members_query);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $members_result = $stmt->get_result();

  if ($members_result && $members_result->num_rows > 0) {
    $row = $members_result->fetch_assoc();
    if ($row['status'] === "deactivate") {
      $_SESSION['failed'] = "Account Deactivated! <br> Your account has been deactivated. Please contact support.";
    } else {
      $_SESSION['member_id'] = $row['member_id'];
      logActivity_member("Member Login", "Member $username logged in", $row['member_id'], $conn);
        // header("Location: ../dental/account/client/dashboard.php");
        header("Location: account/client/dashboard.php");
      exit();
    }
  }

  // Check the admins table if the member is not found
  $admin_query = "SELECT * FROM users WHERE username = ? AND password = ?";
  $stmt = $conn->prepare($admin_query);
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $admin_result = $stmt->get_result();

  if ($admin_result && $admin_result->num_rows > 0) {
    $row = $admin_result->fetch_assoc();
    if ($row['status'] === "not active") {
      // Account is deactivated
      $_SESSION['failed'] = "Account Deactivated! <br> Your account has been deactivated. Please contact support.";
    } else {
      // $_SESSION['user_id'] = $row['user_id'];
      if ($row['role'] == "admin") {
        $_SESSION['admin_id'] = $row['user_id'];
        logActivity_admin("Admin Login", "Admin $username logged in", $row['user_id'], $conn);
        // header("Location: ../dental/account/admin/dashboard.php");
        header("Location: account/admin/dashboard.php");
        exit();
      } else if ($row['role'] == "dentist") {
        $_SESSION['dentist_id'] = $row['user_id'];
        logActivity_admin("Dentist Login", "Dentist $username logged in", $row['user_id'], $conn);
        // header("Location: ../dental/account/dentist/dashboard.php");
        header("Location: account/dentist/dashboard.php");
        exit();
      } else if ($row['role'] == "owner") {
        $_SESSION['super_id'] = $row['user_id'];
        logActivity_admin("Owner Login", "Owner $username logged in", $row['user_id'], $conn);
        // header("Location: ../dental/account/sup-admin/dashboard.php");
        header("Location: account/sup-admin/dashboard.php");
        exit();
      }
    }
  } else {
    $_SESSION['failed'] = "Invalid username or password!"; // Display login error message
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DENTAL CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="./css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style type="text/css">
        /* Service */
        .product-grid-style {
            margin-top: -20px
        }

        img {
            max-width: 100%;
            height: auto;
            vertical-align: top;
        }

        .product-grid-style>[class*="col-"] {
            margin-top: 30px
        }

        .product-grid-style .product-img {
            position: relative
        }

        .product-grid-style .product-img img {
            border-radius: 0.25rem
        }

        .product-grid-style .product-details {
            transition: all .3s ease 0s;
            position: relative
        }

        .product-details .product-cart {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999
        }

        .product-details .product-cart>a {
            width: 40px;
            height: 40px;
            justify-content: center;
            align-items: center;
            display: flex;
            color: #292dc2;
            margin-top: 0;
            margin-right: 10px;
            border-radius: 50%;
            visibility: hidden;
            transition: all 0.5s;
            opacity: 0;
            cursor: pointer;
            background-color: #fff
        }

        .product-details .product-cart a:last-child {
            margin-right: 0
        }

        .product-details .product-cart>a:hover {
            background: #292dc2;
            color: #fff
        }

        .product-details:hover .product-cart a {
            transform: translateY(-30px);
            visibility: visible;
            opacity: 1
        }

        .product-grid-style .product-info {
            padding: 15px;
            float: left;
            width: 100%;
            text-align: center;
            font-size: 18px
        }

        .product-grid-style .product-info>a {
            margin-bottom: 5px;
            display: inline-block;
            font-weight: 600;
            font-size: 15px
        }

        .product-grid-style .price {
            font-weight: 600
        }

        .product-grid-style .price .red {
            color: #878787
        }

        .product-list {
            margin-top: -20px
        }

        .product-list>[class*="col-"] {
            margin-top: 30px
        }

        .product-card {
            border: 1px solid rgba(0, 0, 0, 0.075);
            height: 100%
        }

        .product-card .card-img {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0
        }

        .product-card .card-body {
            padding: 2rem
        }

        .product-card .card-body .read-more {
            display: block
        }

        .product-card .card-body .read-more a {
            color: #292dc2;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px
        }

        .product-card .card-body .read-more a:hover {
            color: #282b2d
        }

        .product-card .card-footer:last-child {
            border-radius: 0
        }

        .product-card h3 {
            font-size: 18px;
            line-height: 26px;
            margin-bottom: 12px
        }

        .product-card h3 a {
            color: #282b2d
        }

        .product-card h3 a:hover {
            color: #292dc2
        }

        .product-card .card-footer {
            background: none;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.8rem 2rem;
            font-weight: 600
        }

        .product-card .card-footer a {
            line-height: normal
        }

        .product-card ul {
            margin-bottom: 0;
            padding-bottom: 0
        }

        .product-card .card-footer img {
            max-width: 35px
        }

        .product-card .card-footer ul li {
            display: inline-block;
            color: #999;
            font-size: 14px;
            font-weight: 500;
            margin: 0 10px 0 0
        }

        .product-card .card-footer ul li i {
            color: #292dc2;
            font-size: 16px;
            font-weight: 500;
            margin-right: 5px
        }

        @media screen and (max-width: 767px) {
            .product-card .card-img.bg-img {
                min-height: 250px
            }
        }

        @media screen and (max-width: 575px) {
            .product-card .card-body {
                padding: 1.5rem
            }
        }

        .product-grid-style .price .red {
            color: #878787;
        }

        .line-through {
            text-decoration: line-through;
        }


        .label-offer {
            position: absolute;
            left: 0;
            top: 0;
            height: 25px;
            line-height: 25px;
            display: inline-block;
            padding: 0px 12px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            z-index: 1
        }

        .bg-red {
            background-color: #ed1b24;
        }

        .bg-primary-solid,
        .primary-overlay-solid[data-overlay-dark]:before {
            background: #292dc2;
        }
    </style>
</head>

<body>
    <!-- nav -->
    <?php include ('./function/nav.php'); ?>
    <!-- nav end -->
    <!-- TOP PART -->
    <section>
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">"The Lord's Smile"
                            </h1>
                            <p class="lead fw-normal text-white-50 mb-4">"Our team delivers gentle, personalized
                                dental solutions. With state-of-the-art technology and a focus on patient education,
                                we're here to help you achieve a healthy, beautiful smile. Schedule your appointment
                                today and let us care for your smile".
                            </p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="./register.php">Get Started</a>
                                <!-- <a class="btn btn-outline-light btn-lg px-4" href="#!">Learn More</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5"
                            src="./picture/dental_home.jpg" alt="..." /></div>
                </div>
            </div>
        </header>
    </section>
    <section class="section about-section" id="about">
        <!-- ad -->
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-0">
                        Better Understanding <br> <strong>Your Dental Needs</strong>.</h2>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature rounded-3 mb-3"><i class="bi bi-building"></i></div>
                            <h2 class="h5">Integration of Behavioral Health in Dentistry</h2>
                            <p class="mb-0">Mental health and oral health
                                are interconnected, and addressing patients' psychological well-being is becoming
                                increasingly important in dental care. </p>
                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5">Focus on Patient-Centered Care</h2>
                            <p class="mb-0"> Dentistry is increasingly focusing on
                                providing personalized, patient-centered care. This involves understanding each
                                patient's unique needs, preferences, and circumstances to tailor treatment plans
                                accordingly. </p>
                        </div>
                        <div class="col h-100">
                            <div class="feature rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                            <h2 class="h5">Emphasis on Holistic Dentistry</h2>
                            <p class="mb-0">There's a growing recognition of the
                                connection between oral health and overall well-being. Holistic dentistry considers not
                                only the teeth and gums but also their impact on the entire body. </p>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                            <h2 class="h5">Online Appointment Scheduling</h2>
                            <p class="mb-0">Implementing an online appointment scheduling
                                system allows patients to book appointments at their convenience, 24/7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about -->
        <div class="container">
            <div class="row align-items-center justify-content-around flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-text">
                        <h3 class="dark-color text-center">Welcome to Dr. L. B. de Guzman Dental Clinic!</h3>
                        <h5 class="theme-color">Your Dental Home 🦷</h5>
                        <p>


                            At <strong>Dr. L. B. de Guzman Dental Clinic,</strong> we are dedicated to revolutionizing
                            your dental care
                            journey. With a passion for excellence and a heart for compassionate service, we strive to
                            elevate your dental treatment experience to new heights.
                            <br>
                            Our commitment to your oral health
                            is unwavering, and we go above and beyond to ensure that every visit leaves you with a smile
                            you'll be proud to share.
                            <br>
                            With state-of-the-art technology and a team of skilled professionals, we promise to provide
                            you with personalized care that meets your unique needs.

                            <br>
                            From routine check-ups to advanced procedures, your comfort and satisfaction are our top
                            priorities.
                            Experience the difference at <strong>Dr. L. B. de Guzman Dental Clinic,</strong> where your
                            smile is our
                            greatest reward. ❤️💜
                        </p>
                        <div class="btn-bar">
                            <a class="px-btn theme" href="./about.php">Learn more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5"
                        src="./picture/dental_about1.jpg" alt="..." /></div>

            </div>
        </div>
    </section>
    <!-- dentist -->
    <section class="ftco-section bg-dark">
        <br>
        <div class="container">
            <div class="row justify-content-center mb-5 pb-5 text-white">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <h2 class="mb-3">Meet Our Experience Dentist</h2>
                    <p>
                        "Meet our experienced dentist, at <strong>Dr. L. B. de Guzman Dental Clinic</strong>. With years
                        of practice and a commitment to
                        excellence, <strong>Dr. L. B. de Guzman Dental Clinic</strong> brings expertise and compassion
                        to every patient interaction."</p>
                </div>
            </div>
            <div class="row">
                <?php $user_query = mysqli_query($conn, "select * from users") or die(mysqli_error($conn));
                while ($row = mysqli_fetch_array($user_query)) {
                    $id = $row['user_id'];
                    if ($row['role'] == 'dentist' || $row['role'] == 'owner') {
                        ?>
                        <div class="col-lg-3 col-md-6 d-flex mb-sm-4">
                            <div class="card" style="width: 18rem;">
                                <?php
                                if (!empty($row['image'])) {
                                    echo '<img class="card-img-top" src="./picture/profile/' . $row['image'] . '" alt="Card image cap">';
                                } else {
                                    echo '<img class="card-img-top" src="./picture/profile/human.png" alt="Card image cap">';
                                }
                                ?>
                                <div class="card-body">
                                    <h4 class="card-title text-center"><a>
                                            <?php echo $row['firstname'] . " " . $row['lastname']; ?>
                                        </a></h4>
                                    <span class="card-text">
                                        <?php echo $row['role']; ?>
                                    </span>
                                    <div>
                                        <p class="text-muted">
                                            <?php echo $row['bio']; ?>
                                        </p>
                                        <ul class="list-group list-group-flush">
                                            <!-- <li class="list-group-item"><a href="#"><span class="icon-facebook"></span></a>
                                            </li>
                                            <li class="list-group-item"><a href="#"><span class="icon-instagram"></span></a>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
            <div class="row  mt-5 justify-conten-center">
                <div class="text-white text-center">
                    <p>"From
                        routine check-ups to complex procedures, rest assured you're in capable hands. Schedule your
                        appointment today and experience personalized care tailored to your needs."</p>
                </div>
            </div>
        </div>
    </section>
    <!-- testimony -->
    <section>
        <!-- Testimonial section-->
        <div class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10 col-xl-7">
                        <div class="row justify-content-center mb-5 pb-3">
                            <div class="col-md-7 text-center heading-section">
                                <h2 class="mb-2">Testimony</h2>
                                <span class="subheading">Our Happy Customer Says</span>
                            </div>
                        </div>
                        <div id="demo" class="carousel slide" data-ride="carousel" data-interval="4000">
                            <div class="carousel-inner">
                                <?php
                                $testimony_query = "SELECT * FROM `testimony`";
                                $testimony_result = mysqli_query($conn, $testimony_query);
                                $first = true; // variable to set the first item as active
                                //while statement
                                while ($testimony = mysqli_fetch_array($testimony_result)) {
                                    // Check if it's the first item, if so, set it as active
                                    $active_class = ($first) ? 'active' : '';
                                    ?>
                                    <div class="carousel-item <?php echo $active_class; ?>">
                                        <div class="text-center">
                                            <div class="fs-4 mb-4 fst-italic">"
                                                <?php echo $testimony['testimony']; ?>"
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img class="rounded-circle me-3"
                                                    src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
                                                <div class="fw-bold">
                                                    <?php echo $testimony['firstname'] . ' ' . $testimony['lastname']; ?>
                                                    <span class="fw-bold text-primary mx-1">/</span>
                                                    <?php echo $testimony['media']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $first = false;
                                } ?>
                            </div>
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- LOG IN -->
    <section class="vh-110" id="#login">
        <br>
        <br><br>
        <form method="post">
            <div class="container-fluid h-custom p-2 text-dark">
                <!-- Image -->
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="./picture/teeth.png" class="img-fluid" alt="Sample image">
                    </div>

                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form>
                            <div
                                class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                                <!-- <button type="button" class="btn btn-primary btn-floating mx-1">
                <i class="fab fa-facebook-f"></i>
              </button>

              <button type="button" class="btn btn-primary btn-floating mx-1">
                <i class="fab fa-twitter"></i>
              </button>

              <button type="button" class="btn btn-primary btn-floating mx-1">
                <i class="fab fa-linkedin-in"></i>
              </button>-->
                            </div>

                            <!-- <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Or</p>
            </div> -->
                            <br>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="username" class="form-control form-control-lg"
                                    placeholder="Enter a valid username" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <!-- Password input -->
                            <div class="input-group mb-3">
                                <div class="input-group">
                                    <input type="password" name="password" id="mypassword"
                                        class="form-control form-control-lg" placeholder="Enter password" />
                                    <div class="input-group-addon">
                                        <input class="" type="checkbox" onclick="myFunction()">
                                    </div>
                                </div>
                                <label class="form-label" for="password">Password</label>
                                <br>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Checkbox -->
                                <div class="form-check mb-0">
                                    <!-- <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">
                                        Remember me
                                    </label> -->
                                </div>
                                <div>
                                    <a href="./password.php" class="text-body">Forgot password?</a>
                                </div>
                            </div>


                            <div class="text-center text-lg-start mt-4 pt-2">
                                <input type="submit" value="Login" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="./register.php"
                                        class="link-primary">Register</a></p>
                            </div>

                        </form>
                        <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                    onclick="window.location.href ='./index.php'"><span aria-hidden="true"><i
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
                                    onclick="window.location.href ='./index.php'"><span aria-hidden="true"><i
                                            class='bx bx-x-circle'></i></span></button>
                                <?php echo $_SESSION['failed']; ?>
                            </div>
                            <?php
                            unset($_SESSION['failed']);
                        } ?>
                        <br>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- Service -->
    <section>
        <br><br>
        <div class="container bootstrap snippets bootdey">
            <section id="services" class="current">
                <div class="services-top">
                    <div class="container bootstrap snippets bootdey">
                        <div class="row text-center">
                            <div class="col-sm-12 col-md-12 col-md-12">
                                <h2>What We Offer</h2>
                                <h2 style="font-size: 60px;line-height: 60px;margin-bottom: 20px;font-weight: 900;">Our
                                    Services</h2>
                                <p>Our <span class="highlight">experienced</span> and <span
                                        class="highlight">dedicated</span> staff provide these services with a smile.
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="container">
                            <div class="row justify-content-center product-grid-style">
                                <div class="row justify-content-center product-grid-style">
                                    <?php
                                    $service_query = "SELECT * FROM `service`";
                                    $service_result = mysqli_query($conn, $service_query);

                                    //while statement
                                    while ($service_row = mysqli_fetch_array($service_result)) {
                                        $service_id = $service_row['service_id'];
                                        $sale_id = $service_row['sale_id'];

                                        $sale_query = mysqli_query($conn, "SELECT * from `sales` WHERE sale_id = '$sale_id' AND status = 'Up'") or die(mysqli_error($conn));
                                        $sale_row = mysqli_fetch_array($sale_query);
                                        if (!empty($service_row['service_id'])) {
                                            if ($service_row['status'] == "Available" && $service_row['highlight'] == "yes") {
                                                ?>
                                                <div class="col-11 col-sm-6 col-lg-4 col-xl-3">
                                                    <div class="product-details">
                                                        <div class="product-img">
                                                            <?php
                                                            if (!empty($sale_row['price_sale'])) { ?>
                                                                <div class="label-offer bg-red">Sale</div>
                                                            <?php } ?>
                                                            <?php if (!empty($service_row['service_image'])) { ?>
                                                                <img src="./picture/service/<?php echo $service_row['service_image']; ?>"
                                                                    alt="...">
                                                            <?php } else { ?>
                                                                <img src="./picture/service/dental_service.jpg" alt="...">
                                                            <?php } ?>
                                                        </div>

                                                        <div class="product-cart">
                                                            <a href="#!"><i class="fa-solid fa fa-eye"></i></a>
                                                            <!-- <a href="#!"><i class="fas fa-cart-plus"></i></a> -->
                                                            <!-- <a href="#!"><i class="fas fa-heart"></i></a> -->
                                                        </div>

                                                        <div class="product-info">
                                                            <a href="#!">
                                                                <?php echo $service_row['service_offer']; ?>
                                                            </a>
                                                            <p class="price text-center m-0 ">
                                                                <?php
                                                                if (!empty($sale_row['price_sale'])) { ?>
                                                                    <span class="red line-through me-2">₱
                                                                        <?php echo $service_row['price']; ?>
                                                                    </span>
                                                                    <span>₱
                                                                        <?php echo $sale_row['price_sale']; ?>
                                                                    </span>
                                                                <?php } else { ?>
                                                                    <span>₱
                                                                        <?php echo $service_row['price']; ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo 'No Service Avaible';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <br><br>
    </section>
    <!-- Footer -->
    <?php include ('./function/footer.php'); ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>

    <!-- Show Password-->
    <script>
        function myFunction() {
            var x = document.getElementById("mypassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>