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
      header("Location: ../dental/account/client/dashboard.php");
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
        header("Location: ../dental/account/admin/dashboard.php");
        // header("Location: account/admin/dashboard.php");
        exit(); // Exit after redirection
      } else if ($row['role'] == "dentist") {
        $_SESSION['dentist_id'] = $row['user_id'];
        logActivity_admin("Dentist Login", "Dentist $username logged in", $row['user_id'], $conn);
        header("Location: ../dental/account/dentist/dashboard.php");
        // header("Location: account/admin/dashboard.php");
        exit(); // Exit after redirection
      } else if ($row['role'] == "owner") {
        $_SESSION['super_id'] = $row['user_id'];
        logActivity_admin("Owner Login", "Owner $username logged in", $row['user_id'], $conn);
        header("Location: ../dental/account/sup-admin/dashboard.php");
        //header("Location: account/admin/dashboard.php");
        exit(); // Exit after redirection
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
  <title>LOG IN</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="./css/styles.css" rel="stylesheet" />
  <!--Online Icon Design;-->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <!--BoxIcons-->
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-image: url('./picture/account-bk.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <!-- nav -->
  <?php include ('./function/nav.php'); ?>
  <!-- nav end -->
  <section class="vh-100">
    <br><br><br>
    <form method="post">
      <div class="container-fluid h-custom bg-success p-2 text-dark bg-opacity-10">
        <!-- Image -->
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="./picture/teeth.png" class="img-fluid" alt="Sample image">
          </div>

          <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form>
              <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
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
              <div class="form-outline mb-3">
                <div class="input-group">
                  <input type="password" name="password" id="mypassword" class="form-control form-control-lg"
                    placeholder="Enter password" />
                  <div class="input-group-addon">
                    <input type="checkbox" onclick="myFunction()">
                  </div>
                </div>
                <label class="form-label" for="password">Password</label>
                <br>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                  <!--<input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                  <label class="form-check-label" for="form2Example3">
                    Remember me
                  </label>-->
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
                <p class="small fw-bold mt-2 pt-1 mb-0"><a href="#!" class="link-secondary">Return to Home Page</a></p>
              </div>
            </form>
            <br>
            <?php if (isset($_SESSION['success'])) { ?>
              <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                  onclick="window.location.href ='./login.php'"><span aria-hidden="true"><i
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
                  onclick="window.location.href ='./login.php'"><span aria-hidden="true"><i
                      class='bx bx-x-circle'></i></span></button>
                <?php echo $_SESSION['failed']; ?>
              </div>
              <?php
              unset($_SESSION['failed']);
            } ?>
          </div>
        </div>
      </div>
    </form>
    <br>
    <footer class="bg-dark footer">
      <div class="footer-bottom small py-3 border-top border-white border-opacity-10">
        <div class="container">
          <div class="row">
            <div class="col-md-6 text-center text-md-start py-1">
              <p class="m-0 text-white text-opacity-75"> Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | This
                Project
                made <i class="icon-heart" aria-hidden="true"></i> by <a class="text-light"
                  href="https://www.facebook.com/ourlittlestudioofficial/" target="_blank">Little
                  Studio</a>
              </p>
            </div>
            <div class="col-md-6 text-center text-md-end py-1">
              <ul class="nav justify-content-center justify-content-md-end list-unstyled footer-link-01 m-0">
                <li class="p-0 mx-3 ms-md-0 me-md-3"><a href="privacy.php" class="text-white text-opacity-75">Privace
                    &amp; Policy</a></li>
                <li class="p-0 mx-3 ms-md-0 me-md-3"><a href="term.php" class="text-white text-opacity-75">Terms
                    and
                    Condition</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section>

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