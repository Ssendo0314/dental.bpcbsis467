<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DENTAL CARE || Terms and Condition</title>
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
                        <h3 class="text-center">TERMS AND CONDITIONS</h3>
                        <h6 class="text-center"> DOCTOR L.B. DE GUZMAN DENTAL CLINIC APPOINTMENT SCHEDULING SYSTEM</h6>
                        <br><br>
                        <div class="col-md-12">
                            <h6>These terms and conditions govern the use of the appointment scheduling
                                system ("the System") provided by Little Studio ("the Company"). By using the System,
                                you agree to comply with
                                and be bound by these terms and conditions. If you do not agree with these terms, please
                                do not
                                use the System.</h6>
                            <br>
                            <h6> 1. User Registration </h6>
                            <li>To utilize the System, users must register and create an account, providing accurate and
                                complete information during registration.</li>
                            <li>Users are responsible for maintaining the confidentiality of their account information
                                and for all activities that occur under their account. </li>
                            <br>
                            <h6>2. Appointment Booking</h6>
                            <li>Users can book appointments through the System, subject to Doctor L.B. De Guzman Dental
                                Clinic's scheduling policies regarding availability.</li>
                            <li>The Company reserves the right to modify, cancel, or reschedule appointments at its
                                discretion.</li>
                            <br>
                            <h6> 3. Cancellation and Rescheduling</h6>
                            <li>Users may cancel or reschedule appointments within the System, adhering to Doctor L.B.
                                De
                                Guzman Dental Clinic's cancellation and rescheduling policies.</li>
                            <li>The Company may impose fees or penalties for late cancellations or no-shows, in
                                accordance
                                with its policies. </li>
                            <br>
                            <h6>4. Data Privacy</h6>
                            <li>Personal data, including names, contact information, and appointment details, may be
                                collected and processed by the Company in line with its Privacy Policy. </li>
                            <li>Users consent to the collection and processing of their personal data by using the
                                System
                                and agree to the terms of the Company's Privacy Policy.</li>
                            <br>
                            <h6>5. System Availability</h6>
                            <li> While the Company will strive to ensure the System's availability, uninterrupted
                                service is
                                not guaranteed. Temporary unavailability may occur due to maintenance or other reasons.
                            </li>
                            <li> The Company bears no liability for any loss or inconvenience resulting from the
                                System's
                                unavailability.</li>
                            <br>
                            <h6>6. User Responsibilities</h6>
                            <li> Users must use the System for its intended purpose and adhere to all applicable laws
                                and
                                regulations. </li>
                            <li> Ensuring the accuracy and currency of information provided during registration and
                                appointment booking is the responsibility of the users. </li>
                            <br>
                            <h6>7. Intellectual Property</h6>
                            <li>The System and its contents are protected by intellectual property rights. Users are
                                prohibited from copying, modifying, or distributing any part of the System without the
                                Company's
                                written consent. </li>
                            <br>
                            <h6>8. Limitation of Liability</h6>
                            <li>The Company holds no liability for any direct, indirect, incidental, consequential, or
                                special damages arising from the use or inability to use the System. </li>
                            <br>
                            <h6>9. Termination</h6>
                            <li> The Company reserves the right to terminate a user's access to the System at any time
                                for a
                                breach of these terms and conditions. </li>
                            <br>
                            <h6>10. Changes to Terms and Conditions</h6>
                            <li> The Company reserves the right to modify these terms and conditions at its discretion.
                                Users will receive notifications of any changes, and continued use of the System after
                                such
                                notification constitutes acceptance of the revised terms. </li>
                            <br>
                            <h6>11. Governing Law and Jurisdiction</h6>
                            <li> These terms and conditions are governed by the laws of the Philippines. Any dispute
                                arising out of or relating to these terms and conditions, or the use of the System shall
                                be
                                subject to the exclusive jurisdiction of the courts in the Philippines. </li>
                            <br>
                            <h6>Acknowledgment:</h6>
                            <p>By using the System, you acknowledge that you have read, understood, and agree to these
                            terms
                            and conditions. If you do not agree with these terms, please do not use the System.</p>
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