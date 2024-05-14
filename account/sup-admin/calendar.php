<?php
// Include the database connection file if not included already
include('./function/alert.php');
// Fetch schedules from the database
$schedules = $conn->query("SELECT * FROM `schedule`");
$sched_res = [];

// Convert date format and store schedules in an associative array
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['date'] = date("Y-m-d\TH:i:s", strtotime($row['date'])); // Format date as per JavaScript Date object
    $sched_res[$row['id']] = $row;
}

// Encode the associative array as JSON for JavaScript usage
$scheds_json = json_encode($sched_res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="../../css/calendar.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--Online Icon Design; BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Calendar - Admin</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            font-family: "Roboto", sans-serif;
            background: darkblue;
            color: #fff;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .calendar {
            font-family: Arial, sans-serif;
        }

        /* Daily Calendar */
        /* Weekly Calendar */
        .calendar {
            display: flex;
            flex-wrap: wrap;
        }

        .today {
            background: #FFF !important;
            position: relative;
        }

        /* event color */

        .event-box {
            font-family: "Roboto", sans-serif;
            background: lightblue;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid darkblue;
            padding: 5px;
            /* Adjusted padding for better spacing */
            margin-bottom: 5px;
            /* Add margin between event boxes */
        }

        .slot-number {
            font-weight: bold;
        }


        button {
            position: relative;
            display: inline-block;
            padding: 0 0.6em;
            overflow: hidden;
            height: 1.9em;
            line-height: 1.9em;
            white-space: nowrap;
            cursor: pointer;
        }

        /* Selection for Status */

        .selected {
            /* background-color: #99ccff; */
        }

        .status-waiting {
            background: orange;
            color: white;
        }

        .status-done {
            background: green;
            color: white;
        }

        .status-cancelled {
            background: red;
            color: white;
        }

        .slot-number {
            font-size: 12px;
            color: #666;
        }

        /* yearly */

        /* .yearly-calendar-container {
            display: inline-block;
        }

        .mini-calendar {
            display: inline-block;
            margin-right: 10px;
            /* Adjust spacing between calendars */
        /* } */

        .mini-calendar-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 70px;
            margin: auto;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-family: Arial, sans-serif;
        }

        /* Custom Calendar Table */
        .mini-calendar {
            border-collapse: collapse;
            width: calc(100% / 1);
        }

        /* Custom Calendar Cell */
        .mini-calendar-cell {
            text-align: center;
            padding: 3px;
            border: 1px solid #ddd;
        }

        /* Custom Today Cell Highlight */
        .mini-calendar-today {
            background-color: #ffcc00;
            font-weight: bold;
        }
    </style>

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
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>My Calendar</strong>

                                </div>
                                <br>
                            </div>
                            <!--Appointment list-->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Appointment</strong>
                                </div>
                                <ul class="list-group">
                                    <?php
                                    // SQL query to get distinct actions and their counts
                                    $action_count_sql = "SELECT status, COUNT(*) AS log_count FROM schedule GROUP BY status";
                                    $action_count_result = $conn->query($action_count_sql);

                                    // Process the data
                                    $action_counts = array();
                                    if ($action_count_result && $action_count_result->num_rows > 0) {
                                        while ($calendar_row = $action_count_result->fetch_assoc()) {
                                            $action_counts[$calendar_row['status']] = $calendar_row['log_count'];
                                        }
                                    }
                                    ?>
                                    <?php foreach ($action_counts as $action => $count): ?>
                                        <?php if ($action !== 'Update Active' && $action !== 'Update Deactive'): ?>
                                            <li
                                                class="test-dark list-group-item d-flex justify-content-between align-items-center">
                                                <?php echo $action ?>
                                                <span class="test-dark"><strong>
                                                        <?php echo $count ?>
                                                    </strong></span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!--Appointment list end-->
                        </div>
                        <!--Calendar-->
                        <di class="col-xl-8">
                            <div class="nav navbar bg-light text-white">
                                <div class="container-fluid">
                                    <a class="navbar-brand" type="button" onclick="goToToday()">Today</a>
                                    <!-- Added Today button -->
                                    <li class="d-inline nav-item"><a class="nav-link" type="button"
                                            onclick="switchToMonthly()">Monthly
                                            View</a>
                                    </li>
                                    <li class="d-inline nav-item"><a class="nav-link" type="button"
                                            onclick="switchToWeekly()">Weekly
                                            View</a>
                                    </li>
                                    <li class="d-inline nav-item"><a class="nav-link" type="button"
                                            onclick="switchToDaily()">Daily
                                            View</a>
                                    </li>
                                    <li class="d-inline nav-item"><a class="nav-link" type="button"
                                            onclick="switchToYearly()">Yearly
                                            View</a>
                                    </li>
                                    <div class="d-flex">
                                        <ul class="nav navbar-nav navbar-right">
                                            <li class="d-inline p-2 nav-item"><a class="nav-link" type="button"
                                                    onclick="previousDate()">Previous</a>
                                            </li>
                                            <li class="d-inline p-2 nav-item"><a class="nav-link" type="button"
                                                    onclick="nextDate()">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- <button onclick="previousDate()">Previous</button>
                            <button onclick="nextDate()">Next</button>
                            <button onclick="goToToday()">Today</button> Added Today button
                            <h3>Calendar</h3>
                            <button onclick="switchToMonthly()">Monthly View</button>
                            <button onclick="switchToWeekly()">Weekly View</button>
                            <button onclick="switchToDaily()">Daily View</button>
                            <button onclick="switchToYearly()">Yearly View</button> -->

                            <div id="monthly-view"></div>
                            <div id="weekly-view"></div>
                            <div id="daily-view"></div>
                            <div id="yearly-view"></div>
                    </div><!--Calendar end-->
                    <br>
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

    <script>
        var currentDate = new Date();
        var d = currentDate.getDate(),
            m = currentDate.getMonth(),
            y = currentDate.getFullYear();

        // Define the scheds object with schedules fetched from PHP
        var scheds = <?php echo $scheds_json; ?>;

        // Empty array to store events
        var events = [];

        // Convert the scheds object into events array
        if (!!scheds) {
            Object.keys(scheds).forEach(function (key) {
                var row = scheds[key];
                events.push({
                    id: row.id,
                    status: row.status,
                    number: row.timeslot,
                    start: new Date(row.date), // Convert the date string to JavaScript Date object
                    end: new Date(row.date) // Adjust as needed if you have different start and end times
                });
            });
        }

        function previousDate() {
            switch (currentView) {
                case 'monthly':
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    populateMonthlyCalendar(currentDate);
                    break;
                case 'weekly':
                    currentDate.setDate(currentDate.getDate() - 7);
                    populateWeeklyCalendar(currentDate);
                    break;
                case 'daily':
                    currentDate.setDate(currentDate.getDate() - 1);
                    populateDailyCalendar(currentDate);
                    break;
                case 'yearly':
                    currentDate.setFullYear(currentDate.getFullYear() - 1);
                    populateYearlyCalendar(currentDate);
                    break;
                default:
                    break;
            }
        }

        function nextDate() {
            switch (currentView) {
                case 'monthly':
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    populateMonthlyCalendar(currentDate);
                    break;
                case 'weekly':
                    currentDate.setDate(currentDate.getDate() + 7);
                    populateWeeklyCalendar(currentDate);
                    break;
                case 'daily':
                    currentDate.setDate(currentDate.getDate() + 1);
                    populateDailyCalendar(currentDate);
                    break;
                case 'yearly':
                    currentDate.setFullYear(currentDate.getFullYear() + 1);
                    populateYearlyCalendar(currentDate);
                    break;
                default:
                    break;
            }
        }

        function goToToday() {
            currentDate = new Date(); // Reset to today's date
            switch (currentView) {
                case 'monthly':
                    populateMonthlyCalendar(currentDate);
                    break;
                case 'weekly':
                    populateWeeklyCalendar(currentDate);
                    break;
                case 'daily':
                    populateDailyCalendar(currentDate);
                    break;
                case 'yearly':
                    populateYearlyCalendar(currentDate);
                    break;
                default:
                    break;
            }
        }

        var currentView = 'monthly'; // Default view

        function switchToMonthly() {
            currentView = 'monthly';
            document.getElementById('monthly-view').style.display = 'block';
            document.getElementById('weekly-view').style.display = 'none';
            document.getElementById('daily-view').style.display = 'none';
            document.getElementById('yearly-view').style.display = 'none';
            populateMonthlyCalendar(currentDate);
        }

        function switchToWeekly() {
            currentView = 'weekly';
            document.getElementById('monthly-view').style.display = 'none';
            document.getElementById('weekly-view').style.display = 'block';
            document.getElementById('daily-view').style.display = 'none';
            document.getElementById('yearly-view').style.display = 'none';
            populateWeeklyCalendar(currentDate);
        }

        function switchToDaily() {
            currentView = 'daily';
            document.getElementById('monthly-view').style.display = 'none';
            document.getElementById('weekly-view').style.display = 'none';
            document.getElementById('daily-view').style.display = 'block';
            document.getElementById('yearly-view').style.display = 'none';
            populateDailyCalendar(currentDate);
        }

        function switchToYearly() {
            currentView = 'yearly';
            document.getElementById('monthly-view').style.display = 'none';
            document.getElementById('weekly-view').style.display = 'none';
            document.getElementById('daily-view').style.display = 'none';
            document.getElementById('yearly-view').style.display = 'block';
            populateYearlyCalendar(currentDate);
        }

        function populateMonthlyCalendar(date) {
            // Implement your monthly calendar population logic here
            const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
            const lastDayOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            const daysInMonth = lastDayOfMonth.getDate();
            const startingDay = firstDayOfMonth.getDay();

            let html = `
        <h2>${moment(date).format('MMMM YYYY')}</h2>
        <table class="calendar-table">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>`;

            let dayCounter = 1;
            let currentDate = new Date(); // Get the current date
            let year = date.getFullYear();
            let month = date.getMonth();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            for (let i = 0; i < 6; i++) {
                html += '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth.getDay()) {
                        html += '<td></td>';
                    } else if (dayCounter > daysInMonth) {
                        html += '<td></td>';
                    } else {
                        let cellClass = (date.getDate() === currentDate.getDate() && month === currentMonth && year === currentYear) ? 'selected' : '';
                        let eventsOnDate = getEventsOnDate(year, month, dayCounter);
                        html += `<td class="${cellClass}" id="events-${year}-${month}-${dayCounter}"><a href="#events-${year}-${month}-${dayCounter}">${dayCounter}</a>`;
                        html += '<br>';
                        html += renderEventsForDate(year, month, dayCounter); // Render events for the date
                        html += '</td>';
                        dayCounter++;
                    }
                }
                html += '</tr>';
            }
            html += '</table>';
            document.getElementById('monthly-view').innerHTML = html;
        }


        // Function to render events for a given date
        function renderEventsForDate(year, month, date) {
            var eventsOnDate = getEventsOnDate(year, month, date);
            var html = '';
            var maxEventsToShow = 2; // Define the maximum number of events to show before displaying "more"
            var hiddenEventsCount = 0; // Variable to count hidden events

            if (eventsOnDate.length <= maxEventsToShow) {
                // If the number of events is less than or equal to the maximum, render all events
                eventsOnDate.forEach(function (event) {
                    html += '<div class="event-box">';
                    html += '<br><span class="slot-number">Slot ' + event.number + '</span>';
                    var eventClass = 'status-' + event.status.toLowerCase();
                    html += '<br><span class="' + eventClass + '">' + event.status + '</span>';
                    // Adding a link to a page with more details
                    html += '<br><a href="./schedule_view.php?id=' + event.id + '">More details</a>';
                    html += '</div>';
                });
            } else {
                // If there are more events than the maximum, render only the first two events
                for (var i = 0; i < maxEventsToShow; i++) {
                    var event = eventsOnDate[i];
                    html += '<div class="event-box">';
                    html += '<br><span class="slot-number">Slot ' + event.number + '</span>';
                    var eventClass = 'status-' + event.status.toLowerCase();
                    html += '<br><span class="' + eventClass + '">' + event.status + '</span>';
                    // Adding a link to a page with more details
                    html += '<br><a href="./schedule_view.php?id=' + event.id + '">More details</a>';
                    html += '</div>';
                }
                hiddenEventsCount = eventsOnDate.length - maxEventsToShow; // Calculate the number of hidden events
            }

            if (hiddenEventsCount > 0) {
                html += '<div class="hidden-events-count">+' + hiddenEventsCount + ' more</div>';
            }


            return html;
        }


        // Function to display all events for a date
        window.showAllEvents = function (year, month, date) {
            var eventBox = document.getElementById('events-' + year + '-' + month + '-' + date);
            eventBox.innerHTML = renderAllEventsForDate(year, month, date);
            var moreButton = eventBox.parentNode.querySelector('button');
            moreButton.innerText = 'Less';
            moreButton.setAttribute('onclick', 'showLessEvents(' + year + ', ' + month + ', ' + date + ')');
        };

        // Function to display limited events for a date
        window.showLessEvents = function (year, month, date) {
            var eventBox = document.getElementById('events-' + year + '-' + month + '-' + date);
            eventBox.innerHTML = renderEventsForDate(year, month, date);
            var moreButton = eventBox.parentNode.querySelector('button');
            moreButton.innerText = 'More';
            moreButton.setAttribute('onclick', 'showAllEvents(' + year + ', ' + month + ', ' + date + ')');
        };

        function getEventsOnDate(year, month, date) {
            var eventsOnDate = [];
            events.forEach(function (event) {
                var eventDate = new Date(event.start);
                if (eventDate.getFullYear() === year && eventDate.getMonth() === month && eventDate.getDate() === date) {
                    eventsOnDate.push(event);
                }
            });
            return eventsOnDate;
        }

        window.selectDate = function (date) {
            var selected = document.querySelector('.selected');
            if (selected) {
                selected.classList.remove('selected');
            }
            event.target.classList.add('selected');

            var year = date.getFullYear();
            var month = date.getMonth();
            var day = date.getDate();

            // Check if the selected date has hidden events
            if (dateHasHiddenEvents(year, month, day)) {
                switchToDaily();
            }

            console.log("Selected date:", date);
        };


        function populateWeeklyCalendar(date) {
            // Implement your weekly calendar population logic here
            const startOfWeek = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()); // Start of the current week
            const endOfWeek = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6); // End of the current week

            let html = `
        <h2>${moment(startOfWeek).format('MMMM DD, YYYY')} - ${moment(endOfWeek).format('MMMM DD, YYYY')}</h2>
        <table class="calendar-table">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>`;

            let currentDate = new Date(); // Get the current date
            let year = startOfWeek.getFullYear();
            let month = startOfWeek.getMonth();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            for (let i = 0; i < 1; i++) { // Only one row for weekly view
                html += '<tr>';
                for (let j = 0; j < 7; j++) {
                    let currentDay = new Date(startOfWeek);
                    currentDay.setDate(startOfWeek.getDate() + j); // Increment current day by j
                    let cellClass = (currentDay.getDate() === currentDate.getDate() && currentDay.getMonth() === currentMonth && currentDay.getFullYear() === currentYear) ? 'selected' : '';
                    let eventsOnDate = getEventsOnDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate());
                    html += `<td class="${cellClass}" id="events-${currentDay.getFullYear()}-${currentDay.getMonth()}-${currentDay.getDate()}"><a href="#events-${currentDay.getFullYear()}-${currentDay.getMonth()}-${currentDay.getDate()}">${currentDay.getDate()}</a>`;
                    html += '<br>';
                    html += renderEventsForDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate()); // Render events for the date
                    html += '</td>';
                }
                html += '</tr>';
            }
            html += '</table>';
            document.getElementById('weekly-view').innerHTML = html;
        }

        function populateDailyCalendar(date) {
            var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            var html = '<table class="calendar-table table table-condensed table-tight">';
            html += '<thead><tr>';
            html += '<th colspan="2" style="text-align: center">' + date.toLocaleDateString("en-US", {
                weekday: "long",
                month: "short",
                day: "numeric",
                year: "numeric"
            }) + '</th>';
            html += '</tr></thead>';
            html += '<tr><th class="c-name">Time</th><th class="c-name">Event</th></tr>';
            html += '<tbody>';

            // Generate time slots from 8 AM to 6 PM (adjust as needed)
            var timeSlots = [];
            for (var hour = 8; hour <= 18; hour++) { // Adjusted time range from 8 AM to 6 PM
                var formattedHour = hour < 10 ? '0' + hour : hour; // Format single-digit hour with leading zero
                timeSlots.push(formattedHour + ':00');
            }

            // Loop over time slots
            for (var i = 0; i < timeSlots.length; i++) {
                html += '<tr>';
                html += '<td class="time-slot">' + timeSlots[i] + '</td>';
                html += '<td class="event-slot">';
                // Loop over 7 days
                for (let j = 0; j < 7; j++) {
                    // Calculate the date for the current iteration
                    let currentDay = new Date(startOfWeek);
                    currentDay.setDate(startOfWeek.getDate() + j); // Increment current day by j
                    let cellClass = (currentDay.getDate() === currentDay && currentDay.getMonth() === currentMonth && currentDay.getFullYear() === currentYear) ? 'selected' : '';
                    let eventsOnDate = getEventsOnDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate());
                    // Generate HTML for the cell
                    html += `<td class="${cellClass}" id="events-${currentDay.getFullYear()}-${currentDay.getMonth()}-${currentDay.getDate()}"><a href="#events-${currentDay.getFullYear()}-${currentDay.getMonth()}-${currentDay.getDate()}">${currentDay.getDate()}</a>`;
                    html += '<br>';
                    html += renderEventsForDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate()); // Render events for the date
                    html += '</td>';
                }
                html += '</td>';
                html += '</tr>';
            }

            html += '</tbody></table>';
            document.getElementById('daily-view').innerHTML = html; // Fixed to set innerHTML instead of appending
        }

        function populateDailyCalendar(date) {
            var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var html = '<table class="calendar-table">';
            html += '<thead><tr>';
            html += '<th colspan="2" style="text-align: center">' + date.toLocaleDateString("en-US", {
                weekday: "long",
                month: "short",
                day: "numeric",
                year: "numeric"
            }) + '</th>';
            html += '</tr></thead>';
            html += '<tr><th class="c-name">Event</th></tr>'; // Only one header for events
            html += '<tbody>';

            // No need to generate time slots

            // Loop over 1 day
            for (let j = 0; j < 1; j++) {
                // Calculate the date for the current iteration
                let currentDay = new Date(date); // Copy the input date
                currentDay.setDate(date.getDate() + j); // Increment current day by j
                let cellClass = (currentDay.getDate() === date.getDate() && currentDay.getMonth() === date.getMonth() && currentDay.getFullYear() === date.getFullYear()) ? 'selected' : '';
                let eventsOnDate = getEventsOnDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate());
                // Generate HTML for the cell
                html += '<tr>';
                html += '<td class="event-slot" id="events-' + currentDay.getFullYear() + '-' + (currentDay.getMonth() + 1) + '-' + currentDay.getDate() + '">';
                html += '<br>';
                html += renderEventsForDate(currentDay.getFullYear(), currentDay.getMonth(), currentDay.getDate()); // Render events for the date
                html += '</td>';
                html += '</tr>';
            }

            html += '</tbody></table>';
            document.getElementById('daily-view').innerHTML = html; // Fixed to set innerHTML instead of appending
        }


        function populateYearlyCalendar(date) {
            // Clear the previous content
            document.getElementById('yearly-view').innerHTML = '';

            // Get the year from the provided date
            const year = moment(date).year();
            const today = moment(date); // Get today's date

            // Create a container for all the tables
            const container = document.createElement('div');
            container.classList.add('yearly-calendar-container');

            // Create a table for each month
            for (let month = 0; month < 12; month++) {
                // Create a new table element
                const table = document.createElement('table');
                table.classList.add('mini-calendar');

                // Create a caption for the month with the year
                const caption = document.createElement('caption');
                caption.textContent = moment().month(month).format('MMMM') + ' ' + year; // Format month name and year
                table.appendChild(caption);

                // Create the table header row
                const headerRow = document.createElement('tr');
                const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                daysOfWeek.forEach(day => {
                    const th = document.createElement('th');
                    th.textContent = day;
                    headerRow.appendChild(th);
                });
                table.appendChild(headerRow);

                // Create the table body
                const body = document.createElement('tbody');

                // Get the first day of the month
                const firstDayOfMonth = moment().year(year).month(month).date(1);

                // Find the starting day of the week for the first day of the month
                const startDayOfWeek = firstDayOfMonth.day();

                // Calculate the number of days in the month
                const daysInMonth = moment().year(year).month(month).daysInMonth();

                // Create rows and cells for each day of the month
                let dayOfMonth = 1;
                for (let i = 0; i < 6; i++) {
                    const row = document.createElement('tr');
                    for (let j = 0; j < 7; j++) {
                        const cell = document.createElement('td');
                        cell.classList.add('mini-calendar-cell');
                        if (i === 0 && j < startDayOfWeek) {
                            // Empty cells before the start day of the month
                            cell.textContent = '';
                        } else if (dayOfMonth <= daysInMonth) {
                            // Fill cells with the day of the month
                            cell.textContent = dayOfMonth;
                            const cellDate = moment().year(year).month(month).date(dayOfMonth);
                            if (cellDate.isSame(today, 'day')) {
                                // Highlight today's date
                                cell.classList.add('mini-calendar-today');
                            }
                            dayOfMonth++;
                        } else {
                            // Empty cells after the end of the month
                            cell.textContent = '';
                        }
                        row.appendChild(cell);
                    }
                    body.appendChild(row);
                }

                // Append the table body to the table
                table.appendChild(body);

                // Append the table to the container
                container.appendChild(table);
            }

            // Append the container to the yearly view
            document.getElementById('yearly-view').appendChild(container);
        }

        // Example usage:
        populateYearlyCalendar(new Date()); // Populate the calendar for the current year


        // Initial call to switchToMonthly to display monthly view by default
        switchToMonthly();
    </script>
</body>

</html>