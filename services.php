<!--code Log In with Post Method-->
<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include ('./dbcon.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
        integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
    <style type="text/css">
        /* Style */
        body {
            margin-top: 20px;
        }

        /* Service */
        body {
            margin-top: 20px;
            background: #F0F8FF;
        }

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

        /* Feature Box */
        .feature-box-1 {
            padding: 32px;
            box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
            margin: 15px 0;
            position: relative;
            z-index: 1;
            border-radius: 10px;
            overflow: hidden;
            -moz-transition: ease all 0.35s;
            -o-transition: ease all 0.35s;
            -webkit-transition: ease all 0.35s;
            transition: ease all 0.35s;
            top: 0;
        }

        .feature-box-1 * {
            -moz-transition: ease all 0.35s;
            -o-transition: ease all 0.35s;
            -webkit-transition: ease all 0.35s;
            transition: ease all 0.35s;
        }

        .feature-box-1 .icon {
            width: 70px;
            height: 70px;
            line-height: 70px;
            background: #fc5356;
            color: #ffffff;
            text-align: center;
            border-radius: 50%;
            margin-bottom: 22px;
            font-size: 27px;
        }

        .feature-box-1 .icon i {
            line-height: 70px;
        }

        .feature-box-1 h5 {
            color: #20247b;
            font-weight: 600;
        }

        .feature-box-1 p {
            margin: 0;
        }

        .feature-box-1:after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: auto;
            right: 0;
            border-radius: 10px;
            width: 0;
            background: #20247b;
            z-index: -1;
            -moz-transition: ease all 0.35s;
            -o-transition: ease all 0.35s;
            -webkit-transition: ease all 0.35s;
            transition: ease all 0.35s;
        }

        .feature-box-1:hover {
            top: -5px;
        }

        .feature-box-1:hover h5 {
            color: #ffffff;
        }

        .feature-box-1:hover p {
            color: rgba(255, 255, 255, 0.8);
        }

        .feature-box-1:hover:after {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            left: 0;
            right: auto;
        }

        .section {
            padding: 100px 0;
            position: relative;
        }

        .section-title {
            padding-bottom: 45px;
        }

        .section-title h2 {
            font-weight: 700;
            color: #20247b;
            font-size: 45px;
            margin: 0 0 15px;
            border-left: 5px solid #fc5356;
            padding-left: 15px;
        }

        /* Footer */
        .wrapper>* {
            flex: 0 0 auto;
        }

        a {
            text-decoration: none;
            background-color: transparent;
        }

        .py-8 {
            padding-top: 3.5rem !important;
            padding-bottom: 3.5rem !important;
        }

        .footer-link-01 li+li {
            padding-top: 0.8rem;
        }

        .footer-title-01 {
            font-size: 16px;
            margin: 0 0 20px;
            font-weight: 600;
        }

        .footer-title-01 {
            font-size: 16px;
            margin: 0 0 20px;
            font-weight: 600
        }

        .footer-link-01 li+li {
            padding-top: .8rem
        }

        @media (max-width: 991.98px) {
            .footer-link-01 li+li {
                padding-top: .6rem
            }
        }

        .footer-link-01 a {
            position: relative;
            display: inline-block;
            vertical-align: top
        }

        .footer-link-01 a:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: auto;
            right: 0;
            width: 0;
            height: 1px;
            transition: ease all .35s;
            background: currentColor
        }

        .footer-link-01 a:hover:after {
            left: 0;
            right: auto;
            width: 100%
        }

        /* Footer */
    </style>
</head>

<body>
    <!-- nav -->
    <?php include ('./function/nav.php'); ?>
    <!-- nav end -->
    <!-- TOP PART -->
    <header class="py-5">
        <div class="container px-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xxl-6">
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
                </div>
            </div>
        </div>
    </header>
    <!-- Service -->
    <section>
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
                                            <img src="./picture/service/<?php echo $service_row['service_image']; ?>" alt="...">
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
                    }
                    ?>
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
    <!-- Service Idea -->
    <section class="section services-section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>What I Do</h2>
                        <p>I design and develop services for customers of all sizes, specializing in creating stylish,
                            modern websites</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Unique design</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Different Layout</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-comment"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Make it Simple</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-image"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Responsiveness</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-th"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Testing for Perfection</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
                <!-- feaure box -->
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-box-1">
                        <div class="icon">
                            <i class="fa fa-cog"></i>
                        </div>
                        <div class="feature-content">
                            <h5>Advanced Options</h5>
                            <p>I design and develop services for customers of all sizes, specializing in creating
                                stylish, modern websites.</p>
                        </div>
                    </div>
                </div>
                <!-- / -->
            </div>
        </div>
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