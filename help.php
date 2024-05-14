<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENTAL CARE || Help Center</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <style>
        #navigationList li a.active-button {
            background-color: #007bff;
            color: white;
        }

        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 12px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ced4da;
            /* Bootstrap border color */
            margin-bottom: 12px;
        }

        #navigationList {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #navigationList li a {
            border: 1px solid #ced4da;
            /* Bootstrap border color */
            margin-top: -1px;
            background-color: #f8f9fa;
            /* Bootstrap background color */
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            color: #495057;
            /* Bootstrap text color */
            display: block;
        }

        #navigationList li a:hover:not(.header) {
            background-color: #e9ecef;
            /* Bootstrap hover background color */
        }
    </style>
</head>

<body>
    <!-- nav -->
    <?php include ('./function/nav.php'); ?>
    <br><br>
    <section>
        <div class="container-fluid">
            <div class="row">
                <!-- Left Side -->
                <div class="col-md-3">
                    <input type="text" class="form-control mb-3" id="myInput" onkeyup="filterNavigation()"
                        placeholder="Search for ..">

                    <ul id="navigationList" class="nav flex-column">
                        <li class="nav-item">
                            <a href="#About" onclick="toggleContentMode('About')">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact_admin" onclick="toggleContentMode('contact_admin')">Admin Account</a>
                        </li>
                        <li class="nav-item">
                            <a href="#appointment" onclick="toggleContentMode('appointment')">Appointment History</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact_client" onclick="toggleContentMode('contact_client')">Client Account</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact_dentist" onclick="toggleContentMode('contact_dentist')">Dentist
                                Account</a>
                        </li>
                        <li class="nav-item">
                            <a href="#service" onclick="toggleContentMode('service')">List of Service</a>
                        </li>
                        <li>
                            <a href="#testimony" onclick="toggleContentMode('testimony')">Testimony</a>
                        </li>
                        <li class="nav-item">
                            <a href="#treatment_plan" onclick="toggleContentMode('treatment_plan')">Treatment Plan</a>
                        </li>
                    </ul>
                </div>

                <!-- Right Side -->
                <div class="col-md-9">
                    <div id="contentAbout" class="content">
                        Result Adele
                    </div>
                    <div id="contentcontact_admin" class="content" style="display: none;">
                        <h3>How to Use: <strong>Admin Account</strong></h3>
                        <hr>
                        <h5>Owner</h5>
                        <br>
                        <h6><b>Table View</b></h6>
                        1. You can Add New Account for Stuff using the <a class="link" onclick="openForm()"><strong><i
                                    class='bx bx-add-to-queue'></i> Add Staff</strong></a>.
                        <br>
                        2. As an Admin Account, You can <strong>Active</strong> and <strong>Deactivate</strong> the
                        Detist Account using
                        the button.
                        <br>
                        3.You can also sort if you want to see <a class="link" href="#"><strong>Admin
                                Account</strong></a>, <a class="link" href="#"><strong>Active</strong></a> and <a
                            class="link" href="#"><strong>Deactivate</strong></a>
                        <br>
                        4. You can View the Account Information of your Staff using the <i
                            class="fas fa-table me-1"></i> DataTable for Contact Staff then select the <i
                            class='bx bxs-info-circle'></i> View Button.
                        <br>
                        5. You can now <a class="link" href="#"><i class='bx bxs-download'></i> Download All</a> the
                        Data of <a class="link" href="#"><strong>Admin Account</strong></a> using the button.
                        <br>
                        6.You can now <a class="Link" href="#"><i class='bx bxs-printer'></i> Print All</a> the data of
                        <a class="link" href="#"><strong>Admin Account</strong></a> using the button.
                        <hr>
                        <h5>Admin</h5>
                        <hr>
                        <h5>Dentist</h5>
                        <hr>
                        <h5>Client</h5>

                        <hr>
                    </div>
                    <div id="contentappointment" class="content" style="display: none;">
                        <h3>How to Use: <strong>Appointment History</strong></h3>
                        <hr>
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
                                    <li><strong>Cancelled:</strong> Appointments that have been cancelled, either by the
                                        user or the
                                        system.</li>
                                </ul>
                            </li>
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
                        <p>
                            <strong>Tips for Usage:</strong>
                            <li><strong>Filtering:</strong> Utilize any available filters to narrow down the appointment
                                history based
                                on
                                specific criteria such as date range, service type, or staff member.</li>
                            <li><strong>Actions:</strong> Depending on the system's capabilities, you may have options
                                to perform
                                actions
                                directly from the Appointment History, such as rescheduling appointments or adding
                                notes.
                            </li>
                            <li><strong>Account Management:</strong> Be mindful that deactivating an account will affect
                                any ongoing or
                                future appointments, so it's recommended to communicate any account changes
                                appropriately.
                            </li>
                        </p>
                        <hr>
                        <h5>Owner</h5>
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
                    </div>
                    <div id="contentcontact_client" class="content" style="display: none;">
                        <h3>How to Use: <strong>Client Account</strong></h3>
                        <hr>
                        <h5>Owner</h5>
                        <br>
                        <h6><b>Table View</b></h6>
                        1. You can <strong><i class='bx bxs-info-circle'></i>View</strong> the
                        infomation of <a class="link" href="#"><strong>Client Account</strong></a>
                        using the button.
                        <br>
                        2. As an Admin Account, You can <strong>Active</strong> and <strong>Deactivate</strong> using
                        the button. <strong> Please Note: Once the Account is Deactivate, all up coming event will be
                            Cancelled</strong>
                        <br>
                        3. You can also sort if you want to see <a class="link" href="#"><strong>Client
                                Account</strong></a>, <a class="link" href="#"><strong>Active</strong></a> and <a
                            class="link" href="#"><strong>Deactivate</strong></a>
                        <br>
                        4. You can now <a class="link" href="#"><i class='bx bxs-download'></i> Download All</a> the
                        Data of <a class="link" href="#"><strong>Client Account</strong></a> using the button.
                        <br>
                        5.You can now <a class="Link" href="#"><i class='bx bxs-printer'></i> Print All</a> the data of
                        <a class="link" href="#"><strong>Client Account</strong></a> using the button.
                        <hr>
                        <h5>Admin</h5>
                        <hr>
                        <h5>Dentist</h5>
                        <hr>
                        <h5>Client</h5>

                        <hr>
                    </div>
                    <div id="contentcontact_dentist" class="content" style="display: none;">
                        <h3>How to Use: <strong>Dentist Account</strong></h3>
                        <hr>
                        <h5>Owner</h5>
                        <br>
                        <h6><b>Table View</b></h6>
                        1. You can Add New Account for Staff using the <a class="link" onclick="openForm()"><strong><i
                                    class='bx bx-add-to-queue'></i> Add Staff</strong></a>.
                        <br>
                        2. As an Super Admin Account, You can <strong>Active</strong> and <strong>Deactivate</strong>
                        the
                        Detist Account using
                        the button.
                        <br>
                        3.You can also sort if you want to see <a class="link" href="#"><strong>Dentist
                                Account</strong></a>, <a class="link" href="#"><strong>Active</strong></a> and <a
                            class="link" href="#"><strong>Deactivate</strong></a>
                        <br>
                        4. You can View the Account Information of your Staff using the <i
                            class="fas fa-table me-1"></i> DataTable for Contact Staff then select the <i
                            class='bx bxs-info-circle'></i> View Button.
                        <br>
                        5. You can now <a class="link" href="#"><i class='bx bxs-download'></i> Download All</a> the
                        Data of <a class="link" href="#"><strong>Dentist Account</strong></a> using the button.
                        <br>
                        6.You can now <a class="Link" href="#"><i class='bx bxs-printer'></i> Print All</a> the data of
                        <a class="link" href="#"><strong>Dentist Account</strong></a> using the button.
                        <hr>
                        <h5>Admin</h5>
                        <hr>
                        <h5>Dentist</h5>
                        <hr>
                        <h5>Client</h5>

                        <hr>
                    </div>
                    <div id="contentservice" class="content" style="display: none;">
                        <h3>How to Use: <strong>List of Service</strong></h3>
                        <hr>
                        <h5>Owner</h5>
                        <br>
                        <h6><b>Table View</b></h6>
                        1. You can Add New Service Offer using the <a class="link" onclick="openForm()"><strong><i
                                    class='bx bx-add-to-queue'></i> Add Service</strong></a>.
                        <br>
                        2. You can Edit the Service Information using the <i class="fas fa-table me-1"></i> DataTable
                        for Contact Staff then select and <i class='bx bxs-edit-alt'></i> Edit Button
                        <br>
                        3. You can Edit the Service if it is <a class="link"
                            href="./service= available.php"><strong>Available</strong></a>
                        and <a class="link" href="./service=not_available.php"><strong>Not Available</strong></a>
                        using the button inside the <i class="fas fa-table me-1"></i> DataTable
                        for Contact Staff.
                        <br>
                        4. You can View the Service if it is <a class="link"
                            href="./service= available.php"><strong>Available</strong></a>
                        and <a class="link" href="./service=not_available.php"><strong>Not Available</strong></a>
                        using the button.
                        <br>
                        <hr>
                    </div>
                    <div id="contenttestimony" class="content" style="display: none;">
                        <h3>How to Use: <strong>Testimony</strong></h3>
                        <hr>
                        <h5>Owner</h5>
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
                        <hr>
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
                        <hr>
                    </div>
                    <div id="contenttreatment_plan" class="content" style="display: none;">
                        <h3>How to Use: <strong></strong></h3>
                        <hr>
                        <h5>Owner</h5>

                        <hr>
                        <h5>Admin</h5>

                        <hr>
                        <h5>Dentist</h5>

                        <hr>
                        <h5>Client</h5>

                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <!-- Footer -->
    <?php include ('./function/footer.php'); ?>

    <script>
        // Function to toggle content based on mode
        function toggleContentMode(mode) {
            var sections = document.querySelectorAll('.content');
            sections.forEach(function (section) {
                if (section.id === "content" + mode) {
                    section.style.display = "block";
                } else {
                    section.style.display = "none";
                }
            });

            // Update URL hash
            history.pushState(null, null, '#' + mode);

            // Remove active class from all navigation links
            var navLinks = document.querySelectorAll('#navigationList a');
            navLinks.forEach(function (link) {
                link.classList.remove('active-button');
            });

            // Add active class to the clicked navigation link
            var clickedLink = document.querySelector('a[href="#' + mode + '"]');
            clickedLink.classList.add('active-button');
        }

        // Function to filter navigation links based on search input
        function filterNavigation() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("navigationList");
            li = ul.getElementsByTagName('li');
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        // Function to check URL for section ID and show corresponding content
        function checkURLForSection() {
            var hash = window.location.hash;
            if (hash) {
                var sectionId = hash.substring(1);
                toggleContentMode(sectionId);
            }
        }

        // Check URL on page load
        window.onload = function () {
            checkURLForSection();
        };
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>