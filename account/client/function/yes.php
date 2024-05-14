<?php 
session_start();

require('../../../dbcon.php'); ?>
<!-- reservation -->
<?php if (isset($_POST['yes'])) {
    $id = $_POST['id'];
    $date1 = $_POST['date1'];
    $timeslot1 = $_POST['timeslot1'];
    $location1 = $_POST['location1'];
    $service1 = $_POST['service1'];
    $dentist1 = $_POST['dentist1'];
    $equal = $_POST['equal'];
    $question1 = $_POST['question1'];

    $service_result = mysqli_query($conn, "insert into schedule (member_id,date,timeslot,location_id,service_id,user_id,number,status,question_id) 
    values('$id','$date1','$timeslot1','$location1','$service1','$dentist1','$equal','Waiting', '$question1')") or die(mysqli_error($conn));

    if ($service_result) {
        $_SESSION['success'] = "Successfully added";
        echo "<script>window.location.href='../dashboard.php'</script>";
    } else {
        $_SESSION['failed'] = "Fail to Add Service";
        echo "<script>window.location.href='../dashboard.php'</script>";
    }
} ?>
<!-- reservation -->