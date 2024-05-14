<!-- Bar Chart of the Schedule -->
<?php
// Include the database connection script
include('./function/alert.php');

// Function to fetch schedule data with week
function getWeeklySchedule($week)
{
    global $conn;
    $sql = "SELECT date, WEEK(date) as week FROM schedule WHERE WEEK(date) = $week"; // Modified SQL query to fetch data for a specific week
    $result = $conn->query($sql);
    $dateLabels = array();
    $dateOccurrences = array();

    // Initialize the occurrences array for all days of the week
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    foreach ($daysOfWeek as $day) {
        $dateLabels[] = $day;
        $dateOccurrences[$day] = 0;
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['date'];
            // Increment the occurrence count for the corresponding day
            $dayOfWeek = date('l', strtotime($date));
            $dateOccurrences[$dayOfWeek]++;
        }
    }
    return array(
        'labels' => $dateLabels,
        'occurrences' => array_values($dateOccurrences)
    );
}

// Handle navigation
$week = isset($_GET['week']) ? $_GET['week'] : date('W'); // Default to current week
$weeklySchedule = getWeeklySchedule($week);
$dateLabels = $weeklySchedule['labels'];
$dateOccurrences = $weeklySchedule['occurrences'];
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Schedule</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php echo $row['user_id']; ?>
    <canvas id="scheduleChart" width="800" height="400"></canvas>
    <div>
        <a href="?week=<?php echo $week - 1; ?>">Previous</a> <!-- Navigate to previous week -->
        <span id="weekLabel">Week <?php echo $week; ?></span> <!-- Display current week -->
        <span id="weekDates"></span> <!-- Display dates for the week -->
        <a href="?week=<?php echo $week + 1; ?>">Next</a> <!-- Navigate to next week -->
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateLabels = <?php echo json_encode($dateLabels); ?>;
            var dateOccurrences = <?php echo json_encode($dateOccurrences); ?>;
            var weekNumber = <?php echo $week; ?>;

            var ctx = document.getElementById('scheduleChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'Events in week',
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: dateOccurrences
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Function to get the start and end dates of the week
            function getWeekDates(week, year) {
                var date = new Date(year, 0, 1 + (week - 1) * 7);
                var startDate = new Date(date);
                var endDate = new Date(date.setDate(date.getDate() + 6));
                return [startDate.toDateString(), endDate.toDateString()];
            }

            var currentYear = new Date().getFullYear();
            var [startDate, endDate] = getWeekDates(weekNumber, currentYear);
            document.getElementById('weekDates').textContent = startDate + ' to ' + endDate;
        });
    </script>
</body>

</html>
