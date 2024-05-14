<?php
// Fetch schedules from the database
$schedules = $conn->query("SELECT * FROM `schedule` Where member_id = {$row['member_id']}");
$sched_res = [];

// Convert date format and store schedules in an associative array
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $schedules_row) {
    $schedules_row['date'] = date("Y-m-d\TH:i:s", strtotime($schedules_row['date'])); // Format date as per JavaScript Date object
    $sched_res[$schedules_row['id']] = $schedules_row;
}

// Encode the associative array as JSON for JavaScript usage
$scheds_json = json_encode($sched_res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 2px;
        }

        th {
            background-color: #f2f2f2;
        }

         /* event color */

         .event-box {
            font-family: "Roboto", sans-serif;
            color: black;
            background: lightblue;
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
    </style>
</head>

<body>

    <div id="calendar"></div>

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

        var calendar = document.getElementById('calendar');
        renderCalendar(currentDate.getFullYear(), currentDate.getMonth());

        function renderCalendar(year, month) {
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var firstDayOfMonth = new Date(year, month, 1).getDay();
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            var html = '<div class="calendar">';
            html += '<div class="calendar-header">';
            html += '<h4>' + monthNames[month] + ' ' + year + '</h4>';
            html += '</div>';
            html += '<table>';
            html += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';
            var date = 1;
            for (var i = 0; i < 6; i++) {
                html += '<tr>';
                for (var j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth) {
                        html += '<td></td>';
                    } else if (date > daysInMonth) {
                        html += '<td></td>';
                    } else {
                        var cellClass = (date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) ? 'selected' : '';
                        var eventsOnDate = getEventsOnDate(year, month, date);
                        html += '<td class="' + cellClass + '" id="events-' + year + '-' + month + '-' + date + '">' + date + '</a>';
                        html += '<br>';
                        html += renderEventsForDate(year, month, date); // Render events for the date
                        html += '</td>';
                        date++;
                    }
                }
                html += '</tr>';
            }
            html += '</table></div>';
            calendar.innerHTML = html;
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
                    html += '</div>';
                }
                hiddenEventsCount = eventsOnDate.length - maxEventsToShow; // Calculate the number of hidden events
            }

            // Display the number of hidden events
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
            console.log("Selected date:", date);
        }

        document.getElementById('todayButton').addEventListener('click', function () {
            var today = new Date();
            renderCalendar(today.getFullYear(), today.getMonth());
        });

        window.prevMonth = function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        window.nextMonth = function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }
    </script>

</body>

</html>