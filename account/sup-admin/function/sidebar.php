<div id="dark-nav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" onclick="toggleMode()">
                        <div class="sb-nav-link-icon"><i class='bx bx-moon'></i></div>
                        Dark/Light Mode
                    </a>
                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                        aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Account
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./contact_client.php">Client Account</a> <!-- CONTACT Client -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseAuth02" aria-expanded="false"
                                aria-controls="pagesCollapseAuth">
                                Staff Account
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth02" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./contact_admin.php">Admin Account</a>
                                    <a class="nav-link" href="./contact_dentist.php">Dentist Account</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages01"
                        aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        My Dental
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages01" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link" href="./service.php">List of Service</a> <!-- Service -->
                            <a class="nav-link" href="./shop.php">Dental Office</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages02"
                        aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        My Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages02" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link" href="./testimony.php">Testimony</a> <!-- Testemony -->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                aria-controls="pagesCollapseAuth">
                                My Reports
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./function/apk_select _nav_history.php">Appointment History</a>
                                    <!-- ap_history -->
                                    <a class="nav-link" href="./function/apk_select _nav_waiting.php">Pending History</a> <!-- ap_waiting -->
                                    <a class="nav-link" href="./function/apk_select _nav_process.php">Process History</a> <!-- ap_process -->
                                    <a class="nav-link" href="./function/apk_select _nav_done.php">Done History</a> <!-- ap_done -->
                                    <a class="nav-link" href="./function/apk_select _nav_cancelled.php">Cancelled History</a>
                                    <!-- ap_cancelled -->
                                </nav>
                            </div>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Addons</div>
                    <a class="nav-link" href="./profile.php?user_id=<?php echo $row['user_id']; ?>"> <!-- profile -->
                        Profile
                    </a>
                    <a class="nav-link" href="./calendar.php"><!-- calendar -->
                        Calendar
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Owner <!-- under account: Owner -->
            </div>
        </nav>
    </div>
</div>
<script>
    function toggleMode() {
        var nav = document.getElementById('sidenavAccordion');
        if (nav.classList.contains('sb-sidenav-dark')) {
            // Switch to dark mode
            nav.classList.remove('sb-sidenav-dark');
            nav.classList.add('sb-sidenav-light');
        } else {
            // Switch to light mode
            nav.classList.remove('sb-sidenav-light');
            nav.classList.add('sb-sidenav-dark');
        }
    }
</script>