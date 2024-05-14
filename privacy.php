<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENTAL CARE || Privacy & Policy </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>

<body>
    <!-- nav -->
    <?php include ('./function/nav.php'); ?>
    <br><br>
    <section>
        <div class="container-fluid">
            <div class="row">
                <!-- Center Side -->
                <div class="col-md-12">
                    <hr>
                    <div id="contentAbout" class="content">
                        <h3 class="text-center">Privacy & Policy</h3>
                        <h6 class="text-center"> DOCTOR L.B. DE GUZMAN DENTAL CLINIC APPOINTMENT SCHEDULING SYSTEM</h6>
                        <br>
                        <div class="col-md-12">
                            <h6>Purpose:</h6>
                            <p>
                                This policy outlines the guidelines and procedures for scheduling appointments using the
                                Doctor L.B. De Guzman Dental Clinic Appointment Scheduling System provided by Little
                                Studio. It ensures efficient and effective management of patient appointments while
                                maintaining a high standard of service.
                            </p>
                            <br>
                            <h6> 1. Appointment Booking:</h6>
                            <li> Patients can schedule appointments through the Doctor L.B. De Guzman Dental Clinic
                                Appointment Scheduling System.</li>
                            <li> Appointments are subject to availability based on the clinic's schedule and the
                                services required.</li>
                            <br>
                            <h6>2. Cancellation and Rescheduling:</h6>
                            <li> Patients are encouraged to provide at least 24 hours' notice for cancellations or
                                rescheduling of appointments.</li>
                            <li> Late cancellations or no-shows may result in a fee, as per the clinic's policy.</li>
                            <br>
                            <h6>3. Arrival Time:</h6>
                            <li> Patients are advised to arrive at the clinic at least 15 minutes before their scheduled
                                appointment time to complete any necessary paperwork and ensure timely service.</li>
                            <li> Late arrival may result in a shortened appointment or rescheduling at the discretion of
                                the clinic.</li>
                            <br>
                            <h6> 4. Emergency Appointments:</h6>
                            <li> In case of dental emergencies, patients should contact the clinic directly to arrange
                                an immediate appointment.</li>
                            <li> Every effort will be made to accommodate emergency appointments promptly.</li>
                            <br>
                            <h6>5. Follow-up Appointments:</h6>
                            <li> Patients requiring follow-up appointments will be advised by their dentist during their
                                initial visit.</li>
                            <li>Follow-up appointments should be scheduled in advance to ensure continuity of care.</li>
                            <br>
                            <h6>6. Privacy and Confidentiality:</h6>
                            <li> Patient information provided during appointment scheduling is confidential and will be
                                handled in accordance with the clinic's Privacy Policy.</li>
                            <li> Patient confidentiality will be always maintained.</li>
                            <br>
                            <h6>7. Changes to Appointments:</h6>
                            <li> Any changes to scheduled appointments should be communicated to the clinic as soon as
                                possible.</li>
                            <li> The clinic reserves the right to modify or reschedule appointments as necessary to
                                accommodate unforeseen circumstances.</li>
                            <br>
                            <h6>8. Compliance:</h6>
                            <li> Patients are expected to comply with all clinic policies and procedures regarding
                                appointment scheduling.</li>
                            <li> Failure to comply may result in restrictions on future appointment scheduling.</li>
                            <br>
                            <h6>9. Feedback and Concerns:</h6>
                            <li> Patients are encouraged to provide feedback or raise concerns regarding appointment
                                scheduling to the clinic management.</li>
                            <li> The clinic will address feedback and concerns promptly and take appropriate action as
                                necessary.</li>
                            <br>
                            <h6>10. Policy Review:</h6>
                            <li> This policy will be reviewed periodically to ensure its effectiveness and relevance.
                            </li>
                            <li> Any updates or revisions to the policy will be communicated to patients as necessary.
                            </li>
                            <br>
                            <h6>Acknowledgment:</h6>
                            <p> By scheduling appointments using the Doctor L.B. De Guzman Dental Clinic Appointment
                                Scheduling System, patients acknowledge that they have read, understood, and agree to
                                comply
                                with this policy.</p>
                            <br>
                            <p>If you have any questions or concerns about these terms and conditions, please contact
                                Little
                                Studio at.</p>
                            <ul>
                                <li><a href="https://www.facebook.com/ourlittlestudioofficial/" target="_blank">Little
                                        Studio</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr>
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