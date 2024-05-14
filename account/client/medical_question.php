<?php include('./function/alert.php'); ?>
<?php
// Assuming you have fetched user information from the database and stored it in $user variable
$userGender = $row['gender']; // Assuming 'gender' is the column name in your database

// Define a message based on the user's gender
if ($userGender === 'female') {
    $genderNotice = "female.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dental || Medical History </title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <!--Online Icon Design;-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--BoxIcons-->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>

    <style>
        body {
            background-image: url('../../picture/Background.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Medical History</h3>
                                </div>
                                <form method="POST" action="./function/add.php">
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Please Complete Your Medical Record for
                                            Better Assistance.</div>
                                        <div class="row">
                                            <!-- First Column Content -->
                                            <div class="col">
                                                <label class="form-label" for="question_one">
                                                    Are you doing health?
                                                </label>
                                                <select class="form-select" id="question_one">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                                <label class="form-label" for="question_two">
                                                    Are you under any medical treatment now?
                                                </label>
                                                <select class="form-select" id="question_two"
                                                    onchange="showSubQuestion_two()">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>

                                                <div id="sub_question_container_two" style="display: none;">
                                                    <label class="form-label" for="sub_question">
                                                        You selected Yes, What condition is being treated?
                                                    </label>
                                                    <input type="text" class="form-control" id="sub_question">
                                                </div>

                                                <label class="form-label" for="question_three">
                                                    Have you ever had any serious illness or surgery?
                                                </label>
                                                <select class="form-select" id="question_three"
                                                    onchange="showSubQuestion_three()">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>

                                                <div id="sub_question_container_three" style="display: none;">
                                                    <label class="form-label" for="sub_question">
                                                        Please specify the details of your illness or surgery:
                                                    </label>
                                                    <input type="text" class="form-control" id="sub_question">
                                                </div>

                                                <label class="form-label" for="question_four">
                                                    Have you ever been hospitalized?
                                                </label>
                                                <select class="form-select" id="question_four"
                                                    onchange="showSubQuestion_four()">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>

                                                <div id="sub_question_container_four" style="display: none;">
                                                    <label class="form-label" for="sub_question">
                                                        Please specify the details of your hospitalization:
                                                    </label>
                                                    <input type="text" class="form-control" id="sub_question">
                                                </div>

                                                <label class="form-label" for="question_five">
                                                    Are you taking any prescription or non-prescription drugs?
                                                </label>
                                                <select class="form-select" id="question_five"
                                                    onchange="showSubQuestion_five()">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>

                                                <div id="sub_question_container_five" style="display: none;">
                                                    <label class="form-label" for="sub_question">
                                                        Please specify the drugs you are taking:
                                                    </label>
                                                    <input type="text" class="form-control" id="sub_question">
                                                </div>
                                                <label class="form-label" for="question_six">
                                                    Do you use any tobacco products?
                                                </label>
                                                <select class="form-select" id="question_six">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                                <label class="form-label" for="question_seven">
                                                    Do you drink alcoholic products?
                                                </label>
                                                <select class="form-select" id="question_seven">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                                <label class="form-label" for="question_eight">
                                                    Do you take any recreational drugs?
                                                </label>
                                                <select class="form-select" id="question_eight">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                                <label class="form-label" for="question_nine">
                                                    Are you allergic to any of the following?
                                                </label>
                                                <div class="form-check mb-3" name="question_check">
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="anesthetics">
                                                    <label class="form-check-label" for="anesthetics">
                                                        Local Anesthetics (e.g., lidocaine)
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="antibiotics">
                                                    <label class="form-check-label" for="antibiotics">
                                                        Antibiotics (e.g., Mefenamic Acid)
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="food">
                                                    <label class="form-check-label" for="food">
                                                        Food
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="hiv/aids">
                                                    <label class="form-check-label" for="sulfur_drugs">
                                                        Sulfur Drugs
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="sti">
                                                    <label class="form-check-label" for="aspirin">
                                                        Aspirin
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="stomach_trouble/ulecr">
                                                    <label class="form-check-label" for="latex">
                                                        Latex (e.g., Gloves)
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="yes"
                                                        id="ainting" onchange="toggleOtherAllergy()">
                                                    <label class="form-check-label" for="other_allergy">
                                                        Other
                                                    </label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" value="no"
                                                        id="no_allergies" onchange="toggleNoAllergies()">
                                                    <label class="form-check-label" for="no_allergies">
                                                        No Allergies
                                                    </label>
                                                    <br>
                                                    <div id="other_allergy_input" style="display: none;">
                                                        <label class="form-label" for="other_allergy_text">
                                                            Please specify in your Other Allergies:
                                                        </label>
                                                        <input class="form-control" type="text" id="other_allergy_text"
                                                            name="other_allergy_text">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Second Column Content -->
                                            <div class="col">
                                                <div class="row">
                                                    <label class="form-label" for="question_ten">
                                                        Do you have any of the following? Please check all that apply.
                                                    </label>
                                                    <!-- First Column Content -->
                                                    <div class="col">
                                                        <div class="form-check mb-3" name="question_check">
                                                            <!-- High Blood Pressure -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="high_blood">
                                                            <label class="form-check-label" for="high_blood">High Blood
                                                                Pressure</label>
                                                            <br>
                                                            <!-- Low Blood Pressure -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="low_blood">
                                                            <label class="form-check-label" for="low_blood">Low Blood
                                                                Pressure</label>
                                                            <br>
                                                            <!-- Epilepsy/Convulsions -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="epilepsy_convulsions">
                                                            <label class="form-check-label"
                                                                for="epilepsy_convulsions">Epilepsy/Convulsions</label>
                                                            <br>
                                                            <!-- HIV/AIDS -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="hiv_aids">
                                                            <label class="form-check-label"
                                                                for="hiv_aids">HIV/AIDS</label>
                                                            <br>
                                                            <!-- STI -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="sti">
                                                            <label class="form-check-label" for="sti">STI</label>
                                                            <br>
                                                            <!-- Stomach Trouble/Ulcer -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="stomach_trouble_ulecr">
                                                            <label class="form-check-label"
                                                                for="stomach_trouble_ulcer">Stomach
                                                                Trouble_Ulcer</label>
                                                            <br>
                                                            <!-- Fainting -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="fainting">
                                                            <label class="form-check-label"
                                                                for="fainting">Fainting</label>
                                                            <br>
                                                            <!-- Radiation Therapy -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="radiation_therapy">
                                                            <label class="form-check-label"
                                                                for="radiation_therapy">Radiation Therapy</label>
                                                            <br>
                                                            <!-- Anaphylaxis -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="anaphylaxis">
                                                            <label class="form-check-label"
                                                                for="anaphylaxis">Anaphylaxis</label>
                                                            <br>
                                                            <!-- Heart Diseases -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="heart_diseases">
                                                            <label class="form-check-label" for="heart_diseases">Heart
                                                                Diseases</label>
                                                            <br>
                                                            <!-- Heart Murmurs -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="heart_murmurs">
                                                            <label class="form-check-label" for="heart_murmurs">Heart
                                                                Murmurs</label>
                                                            <br>
                                                            <!-- Rheumatic Fever -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="rheumatic_fever">
                                                            <label class="form-check-label"
                                                                for="rheumatic_fever">Rheumatic Fever</label>
                                                            <br>
                                                            <!-- Heart Surgery -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="heart_surgery" name="heart_surgery">
                                                            <label class="form-check-label" for="heart_surgery">Heart
                                                                Surgery</label>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <!-- Second Column Content -->
                                                    <div class="col">
                                                        <div class="form-check mb-3" name="question_check">
                                                            <!-- Heart Attack -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="heart_attack" name="heart_attack">
                                                            <label class="form-check-label" for="heart_attack">Heart
                                                                Attack</label>
                                                            <br>
                                                            <!-- Respiratory Problem -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="respiratory_problem" name="respiratory_problem">
                                                            <label class="form-check-label"
                                                                for="respiratory_problem">Respiratory Problem</label>
                                                            <br>
                                                            <!-- Tuberculosis -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="tuberculosis" name="tuberculosis">
                                                            <label class="form-check-label"
                                                                for="tuberculosis">Tuberculosis</label>
                                                            <br>
                                                            <!-- Kidney Diseases -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="kidney_diseases" name="kidney_diseases">
                                                            <label class="form-check-label" for="kidney_diseases">Kidney
                                                                Diseases</label>
                                                            <br>
                                                            <!-- Liver Disease -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="liver_disease" name="liver_disease">
                                                            <label class="form-check-label" for="liver_disease">Liver
                                                                Disease</label>
                                                            <br>
                                                            <!-- Thyroid Problem -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="thyroid_problem" name="thyroid_problem">
                                                            <label class="form-check-label"
                                                                for="thyroid_problem">Thyroid Problem</label>
                                                            <br>
                                                            <!-- Bronchitis -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="bronchitis" name="bronchitis">
                                                            <label class="form-check-label"
                                                                for="bronchitis">Bronchitis</label>
                                                            <br>
                                                            <!-- Cancer/Tumor -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="cancer_tumor" name="cancer_tumor">
                                                            <label class="form-check-label"
                                                                for="cancer_tumor">Cancer/Tumor</label>
                                                            <br>
                                                            <!-- Anemia -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="anemia" name="anemia">
                                                            <label class="form-check-label" for="anemia">Anemia</label>
                                                            <br>
                                                            <!-- Angina Pectoris -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="angina_pectoris" name="angina_pectoris">
                                                            <label class="form-check-label" for="angina_pectoris">Angina
                                                                Pectoris</label>
                                                            <br>
                                                            <!-- Asthma -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="asthma" name="asthma">
                                                            <label class="form-check-label" for="asthma">Asthma</label>
                                                            <br>
                                                            <!-- Emphysema -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="emphysema" name="emphysema">
                                                            <label class="form-check-label"
                                                                for="emphysema">Emphysema</label>
                                                            <br>
                                                            <!-- Diabetes -->
                                                            <input class="form-check-input" type="checkbox" value="yes"
                                                                id="diabetes" name="diabetes">
                                                            <label class="form-check-label"
                                                                for="diabetes">Diabetes</label>
                                                            <br>
                                                        </div>
                                                    </div>
                                                    <div class="form-check mb-3" name="question_check">
                                                        <!-- Other -->
                                                        <input class="form-check-input" type="checkbox" value="yes"
                                                            id="other_diseases" onchange="toggleOtherDiseases()">
                                                        <label class="form-check-label"
                                                            for="other_diseases">Other</label><br>
                                                        <div id="other_diseases_input" style="display: none;">
                                                            <label class="form-label" for="other_diseases_text">Please
                                                                specify any other diseases:</label>
                                                            <input class="form-control" type="text"
                                                                id="other_diseases_text" name="other_diseases_text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($row['gender'] == 'female') { ?>
                                                    <h5>
                                                        this part for
                                                        <?php echo $genderNotice; ?>
                                                    </h5>

                                                    <label class="form-label" for="question_ten">
                                                        Are you pregnant?
                                                    </label>
                                                    <select class="form-select" id="question_ten" name="pregnant"
                                                        onchange="togglePregnancyMonths(this)">
                                                        <?php
                                                        if ($row['gender'] == 'female') {
                                                            echo '<option value="no">No</option>';
                                                            echo '<option value="yes">Yes</option>';
                                                        } else {
                                                            echo '<option value="no" selected>No</option>';
                                                        }
                                                        ?>
                                                    </select>

                                                    <div id="pregnancyMonths" style="display: none;">
                                                        <label class="form-label" for="pregnancy_months">
                                                            Pregnancy Months
                                                        </label>
                                                        <?php
                                                        if ($row['gender'] == 'female') { ?>
                                                            <select class="form-select" id="pregnancy_months"
                                                                name="pregnancy_months">
                                                                <option value="Not pregnant">Not pregnant</option>
                                                                <option value="1">1 month</option>
                                                                <option value="2">2 months</option>
                                                                <option value="3">3 months</option>
                                                                <option value="4">4 months</option>
                                                                <option value="5">5 months</option>
                                                                <option value="6">6 months</option>
                                                                <option value="7">7 months</option>
                                                                <option value="8">8 months</option>
                                                                <option value="9">9 months</option>
                                                                <!-- Add more options for months -->
                                                            </select>
                                                        <?php } else {
                                                            echo '<option value="Not pregnant" selected>Not pregnant</option>';
                                                        } ?>
                                                    </div>
                                                    <label class="form-label" for="question_eleven">
                                                        Are you currently nursing?
                                                    </label>
                                                    <select class="form-select" id="question_eleven" name="nursing">
                                                        <?php
                                                        if ($row['gender'] == 'female') { // Assuming $isWoman is a boolean variable indicating if the user is a woman
                                                            echo '<option value="no">No</option>';
                                                            echo '<option value="yes">Yes</option>';
                                                        } else {
                                                            echo '<option value="no" selected>No</option>'; // Assuming default value if not woman
                                                        }
                                                        ?>
                                                    </select>

                                                    <label class="form-label" for="question_twelve">
                                                        Are you currently taking birth control pills?
                                                    </label>
                                                    <select class="form-select" id="question_twelve" name="birth_control">
                                                        <?php
                                                        if ($row['gender'] == 'female') { // Assuming $isWoman is a boolean variable indicating if the user is a woman
                                                            echo '<option value="no">No</option>';
                                                            echo '<option value="yes">Yes</option>';
                                                        } else {
                                                            echo '<option value="no" selected>No</option>'; // Assuming default value if not woman
                                                        }
                                                        ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $row['member_id']; ?>" id="member_id" name="member_id">
                                    <div class="card-footer text-center py-3">
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#">Return</a>
                                            <button class="btn btn-primary" name="question_response"
                                                type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <br>
        <?php include('./function/footer.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        function showSubQuestion_two() {
            var selectBox = document.getElementById("question_two");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var subQuestionContainer = document.getElementById("sub_question_container_two");

            if (selectedValue === "yes") {
                subQuestionContainer.style.display = "block";
            } else {
                subQuestionContainer.style.display = "none";
            }
        }

        function showSubQuestion_three() {
            var selectBox = document.getElementById("question_three");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var subQuestionContainer = document.getElementById("sub_question_container_three");

            if (selectedValue === "yes") {
                subQuestionContainer.style.display = "block";
            } else {
                subQuestionContainer.style.display = "none";
            }
        }

        function showSubQuestion_four() {
            var selectBox = document.getElementById("question_four");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var subQuestionContainer = document.getElementById("sub_question_container_four");

            if (selectedValue === "yes") {
                subQuestionContainer.style.display = "block";
            } else {
                subQuestionContainer.style.display = "none";
            }
        }

        function showSubQuestion_five() {
            var selectBox = document.getElementById("question_five");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            var subQuestionContainer = document.getElementById("sub_question_container_five");

            if (selectedValue === "yes") {
                subQuestionContainer.style.display = "block";
            } else {
                subQuestionContainer.style.display = "none";
            }
        }

        function toggleOtherAllergy() {
            var otherAllergyCheckbox = document.getElementById("other_allergy");
            var otherAllergyInput = document.getElementById("other_allergy_input");
            if (document.getElementById("ainting").checked) {
                otherAllergyInput.style.display = "block";
            } else {
                otherAllergyInput.style.display = "none";
            }
        }

        function toggleNoAllergies() {
            var noAllergiesCheckbox = document.getElementById('no_allergies');
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#no_allergies)');

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        noAllergiesCheckbox.checked = false;
                    } else {
                        // Check if all other checkboxes are unchecked, then check "No Allergies" checkbox
                        var allUnchecked = true;
                        checkboxes.forEach(function (cb) {
                            if (cb !== noAllergiesCheckbox && cb.checked) {
                                allUnchecked = false;
                            }
                        });
                        if (allUnchecked) {
                            noAllergiesCheckbox.checked = true;
                        }
                    }
                });
            });

            // Uncheck all other checkboxes when "No Allergies" is checked
            noAllergiesCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                }
            });
        }

        function toggleOtherDiseases() {
            var otherDiseasesCheckbox = document.getElementById("other_diseases");
            var otherDiseasesTextInput = document.getElementById("other_diseases_input");

            if (otherDiseasesCheckbox.checked) {
                otherDiseasesTextInput.style.display = "block";
            } else {
                otherDiseasesTextInput.style.display = "none";
            }
        }

        function togglePregnancyMonths(select) {
            var pregnancyMonthsDiv = document.getElementById("pregnancyMonths");
            if (select.value === "yes") {
                pregnancyMonthsDiv.style.display = "block";
            } else {
                pregnancyMonthsDiv.style.display = "none";
            }
        }
    </script>
</body>

</html>