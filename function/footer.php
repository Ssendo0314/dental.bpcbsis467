<style>
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

<section>
    <footer class="bg-dark footer">
        <div class="footer-top py-8">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-8 pe-xxl-10">
                        <div class="row gy-3">
                            <div class="col-6 col-lg-4">
                                <h5 class="text-white footer-title-01">A propos</h5>
                                <ul class="list-unstyled footer-link-01 m-0">
                                    <li><a href="about.php" class="text-white text-opacity-75">About</a></li>
                                    <li><a href="register.php" class="text-white text-opacity-75">Register</a></li>
                                    <li><a href="login.php" class="text-white text-opacity-75">Log In</a></li>
                                    <!-- <li><a href="blog.php" class="text-white text-opacity-75">Blog</a></li> -->
                                    <!-- <li><a href="contact.php" class="text-white text-opacity-75">Contact</a></li> -->
                                </ul>
                            </div>
                            <div class="col-6 col-lg-4">
                                <h5 class="text-white footer-title-01">Need Help?</h5>
                                <ul class="list-unstyled footer-link-01 m-0">
                                    <li><a class="text-white text-opacity-75" href="#">Contact Us</a></li>
                                    <li><a class="text-white text-opacity-75" href="./help.php">FAQs</a></li>
                                    <!-- <li><a class="text-white text-opacity-75" href="#">Offers &amp; Kits</a></li> -->
                                    <!-- <li><a class="text-white text-opacity-75" href="#">Get the app</a></li> -->
                                    <!-- <li><a class="text-white text-opacity-75" href="#">Store locator</a></li> -->
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <h2 class="ftco-heading-2 text-light">Office</h2>
                                <div class=" mb-3">
                                    <ul class="list-unstyled">
                                        <li>
                                            <i class='bx bxs-map'></i><span class="text-light"> Maunlad Ave,
                                                Malolos,
                                                Bulacan,
                                                Menzyland Maunlad Homes</span>
                                        </li>
                                        <br>
                                        <li class="fa-3x">
                                            <a class="text-light"
                                                href="https://www.facebook.com/profile.php?id=100091879197852"><i
                                                    class='bx bxl-facebook-circle'></i></a>
                                            <a class="text-light"
                                                href="https://www.instagram.com/drlbdeguzmandentalclinic?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i
                                                    class='bx bxl-instagram'></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ftco-footer-widget mb-4">
                            <h3 class="ftco-heading-2 text-white">DOCTOR L.B DE GUZMAN DENTAL CLINIC</h3>
                            <p class="text-white">Dr. L. B. de Guzman Dental Clinic is committed on upgrading your
                                dental treatment
                                experience.
                                ❤️💜</p>
                        </div>
                        <div>
                            <ul class="list-unstyled">
                                <li><a class="text-light" href="#"><i class='bx bxs-phone'></i> </span><span
                                            class="page-item">+63
                                            916 778
                                            0865</span></a></li>
                                <li><a class="text-light" href="#"><i class='bx bxl-gmail'></i><span class="page-item">
                                            drlbdeguzmandentalclinic@gmail.com</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <li class="p-0 mx-3 ms-md-0 me-md-3"><a href="privacy.php"
                                    class="text-white text-opacity-75">Privacy
                                    &amp; Policy</a></li>
                            <li class="p-0 mx-3 ms-md-0 me-md-3"><a href="terms.php"
                                    class="text-white text-opacity-75">Terms and Condition</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</section>