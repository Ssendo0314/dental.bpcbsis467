<?php
session_start();
// Include your database connection file
require_once ('../../../dbcon.php'); ?>


<?php
if (isset($_POST['add_imaging_tests'])) {
    // Retrieve data from the form
    $service_id = $_POST['service_id'];
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $member_id = $_POST['member_id'];

    $teeth_no = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70";
    $teeth_side = "Upper Left, Upper Right, Lower Left, Lower Right";

    // Perform any necessary validation here

    // Insert data into the database
    // Replace 'record' with your actual table name
    $sql = "INSERT INTO `record` (`service_id`, `teeth_no`, `teeth_side`, `id`, `user_id`, `member_id`) 
    VALUES ('$service_id', '$teeth_no', '$teeth_side', '$id', '$user_id', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


if (isset($_POST['add_x_ray'])) {
    // Retrieve data from the form
    $service_id = $_POST['service_id'];
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $member_id = $_POST['member_id'];

    $teeth_no = "1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70";
    $teeth_side = "Upper Left, Upper Right, Lower Left, Lower Right";

    // Perform any necessary validation here

    // Insert data into the database
    // Replace 'record' with your actual table name
    $sql = "INSERT INTO `record` (`service_id`, `teeth_no`, `teeth_side`, `id`, `user_id`, `member_id`) 
    VALUES ('$service_id', '$teeth_no', '$teeth_side', '$id', '$user_id', '$member_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<?php
// Function to log activities
function testimony_logActivity_admin($action, $description, $member_id, $conn)
{
    // Sanitize input
    $action = mysqli_real_escape_string($conn, $action);
    $description = mysqli_real_escape_string($conn, $description);
    $member_id = mysqli_real_escape_string($conn, $member_id);

    // Get timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Prepare and execute query using prepared statements
    $sql = "INSERT INTO activity_logs (action, description, member_id, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $description, $member_id, $timestamp);
    if ($stmt->execute()) {
        //echo "Activity logged successfully";
    } else {
        //echo "Error logging activity: " . $conn->error;
    }
}

// Usage:
if (isset($_POST['testimony_add'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $testimony = $_POST['testimony'];
    $location_id = $_POST['location_id'];
    $star = $_POST['star'];
    $media = $_POST['media'];
    $service_id = $_POST['service_id'];
    $id = $_POST['id'];
    $member_id = $_POST['member_id'];

    // Establish database connection ($conn assumed to be available)

    // Log the beginning of the activity
    testimony_logActivity_admin("Adding testimony", "Adding testimony for $firstname $lastname with location ID $location_id", $member_id, $conn);

    $testimony_query = "INSERT INTO `testimony`( `firstname`, `lastname`, `testimony`,`location_id`,`star`,`media`, `service_id`, `id`) 
                    VALUES ('$firstname','$lastname','$testimony','$location_id','$star','$media', '$service_id','$id')";
    $testimony_result = mysqli_query($conn, $testimony_query);

    // Log the result of the query
    if ($testimony_result) {
        // Log success message
        testimony_logActivity_admin("Testimony added", "Testimony successfully added for $firstname $lastname", $member_id, $conn);
        $_SESSION['success'] = "Successfully added";
    } else {
        // Log failure message
        testimony_logActivity_admin("Failed to add testimony", "Failed to add testimony for $firstname $lastname", $member_id, $conn);
        $_SESSION['failed'] = "Fail to Add Service";
    }
}

?>

<?php
// Add for the medical information
// Check if form is submitted
if (isset($_POST['question_response'])) {
    // Assign form data to variables
    function sanitize($data)
    {
        return htmlspecialchars(strip_tags($data));
    }

    function normalize($value)
    {
        return $value == 'yes' ? 'yes' : 'No';
    }


    // Assign form data to variables
    $question_one = isset($_POST['question_one']) ? sanitize($_POST['question_one'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_two = isset($_POST['question_two']) ? sanitize($_POST['question_two'] == 'yes' ? 'yes' : 'No') : 'No';
    $sub_question_two = isset($_POST['sub_question_two']) ? sanitize($_POST['sub_question_two']) : '';
    $question_three = isset($_POST['question_three']) ? sanitize($_POST['question_three'] == 'yes' ? 'yes' : 'No') : 'No';
    $sub_question_three = isset($_POST['sub_question_three']) ? sanitize($_POST['sub_question_three']) : '';
    $question_four = isset($_POST['question_four']) ? sanitize($_POST['question_four'] == 'yes' ? 'yes' : 'No') : 'No';
    $sub_question_four = isset($_POST['sub_question_four']) ? sanitize($_POST['sub_question_four']) : '';
    $question_five = isset($_POST['question_five']) ? sanitize($_POST['question_five'] == 'yes' ? 'yes' : 'No') : 'No';
    $sub_question_five = isset($_POST['sub_question_five']) ? sanitize($_POST['sub_question_five']) : '';
    $question_six = isset($_POST['question_six']) ? sanitize($_POST['question_six'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_seven = isset($_POST['question_seven']) ? sanitize($_POST['question_seven'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_eight = isset($_POST['question_eight']) ? sanitize($_POST['question_eight'] == 'yes' ? 'yes' : 'No') : 'No';

    //question 9
    $question_nine_anesthetics = isset($_POST['question_nine_anesthetics']) ? ($_POST['question_nine_anesthetics'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_antibiotics = isset($_POST['question_nine_antibiotics']) ? ($_POST['question_nine_antibiotics'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_food = isset($_POST['question_nine_food']) ? ($_POST['question_nine_food'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_sulfur_drugs = isset($_POST['question_nine_sulfur_drugs']) ? ($_POST['question_nine_sulfur_drugs'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_aspirin = isset($_POST['question_nine_aspirin']) ? ($_POST['question_nine_aspirin'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_latex = isset($_POST['question_nine_latex']) ? ($_POST['question_nine_latex'] == 'yes' ? 'yes' : 'No') : 'No';
    $question_nine_other_allergy = isset($_POST['question_nine_other_allergy ']) ? sanitize($_POST['question_nine_other_allergy ']) : '';
    $question_nine_no_allergies = isset($_POST['question_nine_no_allergies']) ? ($_POST['question_nine_no_allergies'] == 'No' ? 'No' : 'yes') : 'yes';

    //question 10
    $high_blood = isset($_POST['high_blood']) ? ($_POST['high_blood'] == 'yes' ? 'yes' : 'No') : 'No';
    $low_blood = isset($_POST['low_blood']) ? ($_POST['low_blood'] == 'yes' ? 'yes' : 'No') : 'No';
    $epilepsy_convulsions = isset($_POST['epilepsy_convulsions']) ? ($_POST['epilepsy_convulsions'] == 'yes' ? 'yes' : 'No') : 'No';
    $hiv_aids = isset($_POST['hiv_aids']) ? ($_POST['hiv_aids'] == 'yes' ? 'yes' : 'No') : 'No';
    $sti = isset($_POST['sti']) ? ($_POST['sti'] == 'yes' ? 'yes' : 'No') : 'No';
    $stomach_trouble_ulcer = isset($_POST['stomach_trouble_ulcer']) ? ($_POST['stomach_trouble_ulcer'] == 'yes' ? 'yes' : 'No') : 'No';
    $fainting = isset($_POST['fainting']) ? ($_POST['fainting'] == 'yes' ? 'yes' : 'No') : 'No';
    $radiation_therapy = isset($_POST['radiation_therapy']) ? ($_POST['radiation_therapy'] == 'yes' ? 'yes' : 'No') : 'No';
    $anaphylaxis = isset($_POST['anaphylaxis']) ? ($_POST['anaphylaxis'] == 'yes' ? 'yes' : 'No') : 'No';
    $heart_diseases = isset($_POST['heart_diseases']) ? ($_POST['heart_diseases'] == 'yes' ? 'yes' : 'No') : 'No';
    $heart_murmurs = isset($_POST['heart_murmurs']) ? ($_POST['heart_murmurs'] == 'yes' ? 'yes' : 'No') : 'No';
    $rheumatic_fever = isset($_POST['rheumatic_fever']) ? ($_POST['rheumatic_fever'] == 'yes' ? 'yes' : 'No') : 'No';
    $heart_surgery = isset($_POST['heart_surgery']) ? ($_POST['heart_surgery'] == 'yes' ? 'yes' : 'No') : 'No';
    $heart_attack = isset($_POST['heart_attack']) ? ($_POST['heart_attack'] == 'yes' ? 'yes' : 'No') : 'No';
    $respiratory_problem = isset($_POST['respiratory_problem']) ? ($_POST['respiratory_problem'] == 'yes' ? 'yes' : 'No') : 'No';
    $tuberculosis = isset($_POST['tuberculosis']) ? ($_POST['tuberculosis'] == 'yes' ? 'yes' : 'No') : 'No';
    $kidney_diseases = isset($_POST['kidney_diseases']) ? ($_POST['kidney_diseases'] == 'yes' ? 'yes' : 'No') : 'No';
    $liver_disease = isset($_POST['liver_disease']) ? ($_POST['liver_disease'] == 'yes' ? 'yes' : 'No') : 'No';
    $thyroid_problem = isset($_POST['thyroid_problem']) ? ($_POST['thyroid_problem'] == 'yes' ? 'yes' : 'No') : 'No';
    $bronchitis = isset($_POST['bronchitis']) ? ($_POST['bronchitis'] == 'yes' ? 'yes' : 'No') : 'No';
    $cancer_tumor = isset($_POST['cancer_tumor']) ? ($_POST['cancer_tumor'] == 'yes' ? 'yes' : 'No') : 'No';
    $anemia = isset($_POST['anemia']) ? ($_POST['anemia'] == 'yes' ? 'yes' : 'No') : 'No';
    $angina_pectoris = isset($_POST['angina_pectoris']) ? ($_POST['angina_pectoris'] == 'yes' ? 'yes' : 'No') : 'No';
    $asthma = isset($_POST['asthma']) ? ($_POST['asthma'] == 'yes' ? 'yes' : 'No') : 'No';
    $emphysema = isset($_POST['emphysema']) ? ($_POST['emphysema'] == 'yes' ? 'yes' : 'No') : 'No';
    $diabetes = isset($_POST['diabetes']) ? ($_POST['diabetes'] == 'yes' ? 'yes' : 'No') : 'No';
    $other_diseases = isset($_POST['other_diseases']) ? sanitize($_POST['other_diseases']) : '';
    // for woman
    $pregnant = isset($_POST['pregnant']) ? ($_POST['pregnant'] == 'yes' ? 'yes' : 'No') : 'No';
    $pregnancy_months = $_POST['pregnancy_months'];
    $nursing = isset($_POST['nursing']) ? ($_POST['nursing'] == 'yes' ? 'yes' : 'No') : 'No';
    $birth_control = isset($_POST['birth_control']) ? ($_POST['birth_control'] == 'yes' ? 'yes' : 'No') : 'No';
    // Get the member_id from the session
    $member_id = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : '';

    // Prepare SQL statement
    $sql = "INSERT INTO `survey_responses`(`question_one`, `question_two`, `sub_question_two`, `question_three`, 
    `sub_question_three`, `question_four`, `sub_question_four`, `question_five`, `sub_question_five`, `question_six`, 
    `question_seven`, `question_eight`, `question_nine_anesthetics`, `question_nine_antibiotics`, `question_nine_food`, `question_nine_sulfur_drugs`, `question_nine_aspirin`, `question_nine_latex`, 
    `question_nine_other_allergy`, `question_nine_no_allergies`, `high_blood`, `low_blood`, `epilepsy_convulsions`, `hiv_aids`, `sti`, `stomach_trouble_ulcer`, `fainting`, `radiation_therapy`, `anaphylaxis`,
     `heart_diseases`, `heart_murmurs`, `rheumatic_fever`, `heart_surgery`, `heart_attack`, `respiratory_problem`, `tuberculosis`, `kidney_diseases`, `liver_disease`, `thyroid_problem`, `bronchitis`, 
     `cancer_tumor`, `anemia`, `angina_pectoris`, `asthma`, `emphysema`, `diabetes`, `other_diseases`, `pregnant`, `pregnancy_months`, `nursing`, `birth_control`)
    
    VALUES ('$question_one', '$question_two ', '$sub_question_two', '$question_three', '$sub_question_three', '$question_four', '$sub_question_four', '$question_five', '$sub_question_five', 
    '$question_six', '$question_seven', '$question_seven''$question_eight','$question_nine_anesthetics','$question_nine_antibiotics','$question_nine_food','$question_nine_sulfur_drugs','$question_nine_aspirin','$question_nine_latex',
    '$question_nine_other_allergy', '$question_nine_no_allergies', '$high_blood', '$low_blood', '$epilepsy_convulsions', '$hiv_aids','$sti','$stomach_trouble_ulcer','$fainting', 
    '$radiation_therapy', '$anaphylaxis', '$heart_diseases', '$heart_murmurs','$rheumatic_fever', '$heart_surgery','$heart_attack','$respiratory_problem','$tuberculosis','$kidney_diseases', '$liver_disease', 
    '$thyroid_problem','$bronchitis','$cancer_tumor', '$anemia','$angina_pectoris', '$asthma','$emphysema', '$diabetes', '$other_diseases','$pregnant', '$pregnancy_months', '$nursing', '$birth_control')";

    // Execute statement
    if ($conn->query($sql) === TRUE) {

        $response_id = $conn->insert_id; // Get the ID of the inserted record

        // Prepare SQL statement for members table
        $insert_member_sql = "UPDATE members SET question_id = '$response_id' WHERE member_id = '$member_id'";

        // Execute statement for members table
        if ($conn->query($insert_member_sql) !== TRUE) {
            echo "Error inserting member: " . $conn->error;
        }

        // Add activity log
        $action = "New Medical Q and A";
        $activity_log = "New Medical Q and A inserted successfully for member ID: $member_id";
        // Assuming you have a table `activity_logs` with columns `action`, `description`, `member_id`, and `timestamp`
        $activity_sql = "INSERT INTO activity_logs (`action`, `description`, `member_id`, `timestamp`) VALUES ('$action','$activity_log', '$member_id', NOW())";
        if ($conn->query($activity_sql) !== TRUE) {
            echo "Error adding activity log: " . $conn->error;
        }

        // Show success message and ID of the inserted record
        $_SESSION['success'] = "Successfully added! <br> New record inserted successfully. ";
        // Show success message and redirect back to previous page
        echo '<script>alert("New record inserted successfully."); window.location.href = "../dashboard.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!-- <script>window.history.back();</script> -->