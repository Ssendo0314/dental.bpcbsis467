<?php
    //Profile show
    $id = $_GET['id'];
    $schedule_query = "select * from schedule where id = ' $id'";
    $schedule_result = mysqli_query($conn, $schedule_query);
    // Fetch the schedule row
    while ($schedule_row = mysqli_fetch_assoc($schedule_result)) {
        $question_id = $row['question_id'];

        /* question query  */
        $question_query = mysqli_query($conn, "select * from survey_responses where question_id = '$question_id' ") or die(mysqli_error($conn));
        $question_row = mysqli_fetch_array($question_query);

        if (!empty($row['question_id'])) { ?>
            <div class="form-group">
                <div class="col-xs-12">
                    <label class="form-label" for="question_one">
                        Are you doing health?
                    </label>
                    <input class="form-control" id="question_one" value="<?php echo $question_row['question_one']; ?>" disabled>
                    <label class="form-label" for="question_two">
                        Are you under any medical treatment now?
                    </label>
                    <input class="form-control" id="question_two" value="<?php echo $question_row['question_two']; ?>" disabled>
                    <label class="form-label" for="sub_question">
                        You selected Yes, What condition is being treated?
                    </label>
                    <?php
                    if (!empty($question_row['sub_question_two'])) { ?>
                        <input type="text" class="form-control" id="sub_question"
                            value="<?php echo $question_row['sub_question_two']; ?>" disabled>
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sub_question" value="No Ongoing Medical Treatment" disabled>
                    <?php }
                    ?>
                    <label class="form-label" for="question_three">
                        Have you ever had any serious illness or surgery?
                    </label>
                    <input class="form-control" id="question_three" value="<?php echo $question_row['question_three']; ?>"
                        disabled>

                    <label class="form-label" for="sub_question">
                        Please specify the details of your illness or surgery:
                    </label>
                    <?php
                    if (!empty($question_row['sub_question_three'])) { ?>
                        <input type="text" class="form-control" id="sub_question"
                            value="<?php echo $question_row['sub_question_three']; ?>" disabled>
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sub_question" value="No! serious illness or surger" disabled>
                    <?php }
                    ?>
                    <br>
                    <label class="form-label" for="question_four">
                        Have you ever been hospitalized?
                    </label>
                    <input class="form-control" id="question_four" value="<?php echo $question_row['question_three']; ?>"
                        disabled>
                    <br>
                    <label class="form-label" for="sub_question">
                        Please specify the details of your hospitalization:
                    </label>
                    <?php
                    if (!empty($question_row['sub_question_four'])) { ?>
                        <input type="text" class="form-control" id="sub_question"
                            value="<?php echo $question_row['sub_question_four']; ?>" disabled>
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sub_question" value="member not hospitalization" disabled>
                    <?php }
                    ?>
                    <br>
                    <label class="form-label" for="question_five">
                        Are you taking any prescription or non-prescription drugs?
                    </label>
                    <input class="form-control" id="question_five" value="<?php echo $question_row['question_five']; ?>"
                        disabled>
                    <br>
                    <label class="form-label" for="sub_question">
                        Please specify the drugs you are taking:
                    </label>
                    <?php if (!empty($question_row['sub_question_five'])) { ?>
                        <input type="text" class="form-control" id="sub_question"
                            value="<?php echo $question_row['sub_question_five']; ?>" disabled>
                    <?php } else { ?>
                        <input type="text" class="form-control" id="sub_question" value="Not taking any specify the drugs" disabled>
                    <?php }
                    ?>
                    <label class="form-label" for="question_six">
                        Do you use any tobacco products?
                    </label>
                    <input class="form-control" id="question_six" value="<?php echo $question_row['question_six']; ?>" disabled>
                    <br>
                    <label class="form-label" for="question_seven">
                        Do you drink alcoholic products?
                    </label>
                    <input class="form-control" id="question_seven" value="<?php echo $question_row['question_seven']; ?>"
                        disabled>
                    <br>
                    <label class="form-label" for="question_eight">
                        Do you take any recreational drugs?
                    </label>
                    <input class="form-control" id="question_eight" value="<?php echo $question_row['question_eight']; ?>"
                        disabled>
                    <br>
                    <label class="form-label" for="question_nine">
                        Are you allergic to any of the following?
                    </label>
                    <div class="form-check mb-3" name="question_check">
                        <label class="form-check-label" for="anesthetics">
                            Local Anesthetics (e.g., lidocaine)
                        </label>
                        <input class="form-control" type="text"
                            value="<?php echo $question_row['question_nine_anesthetics']; ?>" id="anesthetics" disabled>
                        <br>
                        <label class="form-check-label" for="antibiotics">
                            Antibiotics (e.g., Mefenamic Acid)
                        </label>
                        <input class="form-control" type="text"
                            value="<?php echo $question_row['question_nine_antibiotics']; ?>" id="antibiotics" disabled>
                        <br>
                        <label class="form-check-label" for="food">
                            Food
                        </label>
                        <input class="form-control" type="text" value="<?php echo $question_row['question_nine_food']; ?>"
                            id="food">
                        <br>
                        <label class="form-check-label" for="sulfur_drugs">
                            Sulfur Drugs
                        </label>
                        <input class="form-control" type="text"
                            value="<?php echo $question_row['question_nine_sulfur_drugs']; ?>" id="sulfur_drugs" disabled>
                        <br>
                        <label class="form-check-label" for="aspirin">
                            Aspirin
                        </label>
                        <input class="form-control" type="text" value="<?php echo $question_row['question_nine_aspirin']; ?>"
                            id="asprin" disabled>
                        <br>
                        <label class="form-check-label" for="latex">
                            Latex (e.g., Gloves)
                        </label>
                        <input class="form-control" type="text" value="<?php echo $question_row['question_nine_latex']; ?>"
                            id="stomach_trouble/ulecr" disabled>
                        <br>
                        <label class="form-label" for="other_allergy_text">
                            Please specify in your Other Allergies:
                        </label>
                        <?php if (!empty($question_row['other_allergy_text'])) { ?>
                            <input type="text" class="form-control" id="sub_question"
                                value="<?php echo $question_row['other_allergy_text']; ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="No specify in your Other Allergies"
                                disabled>
                        <?php }
                        ?>
                        <br>
                        <label class="form-check-label" for="no_allergies">
                            No Allergies
                        </label>
                        <input class="form-control" type="text"
                            value="<?php echo $question_row['question_nine_no_allergies']; ?>" id="no_allergies" disabled>
                        <br>
                        <br><br>
                        <label class="form-label" for="question_ten">
                            Do you have any of the following? Please check all that apply.
                        </label>
                        <!-- First Column Content -->
                        <div class="row">
                            <div class="col">
                                <div class="form-check mb-3" name="question_check">
                                    <!-- High Blood Pressure -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['high_blood']; ?>"
                                        id="high_blood" disabled>
                                    <label class="form-check-label" for="high_blood">High Blood
                                        Pressure</label>
                                    <br>
                                    <!-- Low Blood Pressure -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['low_blood']; ?>"
                                        id="low_blood" disabled>
                                    <label class="form-check-label" for="low_blood">Low Blood
                                        Pressure</label>
                                    <br>
                                    <!-- Epilepsy/Convulsions -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['epilepsy_convulsions']; ?>" id="epilepsy_convulsions"
                                        disabled>
                                    <label class="form-check-label" for="epilepsy_convulsions">Epilepsy/Convulsions</label>
                                    <br>
                                    <!-- HIV/AIDS -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['hiv_aids']; ?>"
                                        id="hiv_aids" disabled>
                                    <label class="form-check-label" for="hiv_aids">HIV/AIDS</label>
                                    <br>
                                    <!-- STI -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['sti']; ?>" id="sti"
                                        disabled>
                                    <label class="form-check-label" for="sti">STI</label>
                                    <br>
                                    <!-- Stomach Trouble/Ulcer -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['stomach_trouble_ulcer']; ?>" id="stomach_trouble_ulcer"
                                        disabled>
                                    <label class="form-check-label" for="stomach_trouble_ulcer">Stomach
                                        Trouble/Ulcer</label>
                                    <br>
                                    <!-- Fainting -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['fainting']; ?>"
                                        id="fainting" disabled>
                                    <label class="form-check-label" for="fainting">Fainting</label>
                                    <br>
                                    <!-- Radiation Therapy -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['radiation_therapy']; ?>" id="radiation_therapy"
                                        disabled>
                                    <label class="form-check-label" for="radiation_therapy">Radiation
                                        Therapy</label>
                                    <br>
                                    <!-- Anaphylaxis -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['anaphylaxis']; ?>"
                                        id="anaphylaxis" disabled>
                                    <label class="form-check-label" for="anaphylaxis">Anaphylaxis</label>
                                    <br>
                                    <!-- Heart Diseases -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['heart_diseases']; ?>" id="heart_diseases" disabled>
                                    <label class="form-check-label" for="heart_diseases">Heart
                                        Diseases</label>
                                    <br>
                                    <!-- Heart Murmurs -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['heart_murmurs']; ?>" id="heart_murmurs" disabled>
                                    <label class="form-check-label" for="heart_murmurs">Heart
                                        Murmurs</label>
                                    <br>
                                    <!-- Rheumatic Fever -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['rheumatic_fever']; ?>" id="rheumatic_fever" disabled>
                                    <label class="form-check-label" for="rheumatic_fever">Rheumatic
                                        Fever</label>
                                    <br>
                                    <!-- Heart Surgery -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['heart_surgery']; ?>" id="heart_surgery"
                                        name="heart_surgery" disabled>
                                    <label class="form-check-label" for="heart_surgery">Heart
                                        Surgery</label>
                                    <br>
                                </div>
                            </div>
                            <!-- Second Column Content -->
                            <div class="col">
                                <div class="form-check mb-3" name="question_check">
                                    <!-- Heart Attack -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['heart_attack']; ?>"
                                        id="heart_attack" name="heart_attack" disabled>
                                    <label class="form-check-label" for="heart_attack">Heart
                                        Attack</label>
                                    <br>
                                    <!-- Respiratory Problem -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['respiratory_problem']; ?>" id="respiratory_problem"
                                        name="respiratory_problem" disabled>
                                    <label class="form-check-label" for="respiratory_problem">Respiratory
                                        Problem</label>
                                    <br>
                                    <!-- Tuberculosis -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['tuberculosis']; ?>"
                                        id="tuberculosis" name="tuberculosis" disabled>
                                    <label class="form-check-label" for="tuberculosis">Tuberculosis</label>
                                    <br>
                                    <!-- Kidney Diseases -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['kidney_diseases']; ?>" id="kidney_diseases"
                                        name="kidney_diseases" disabled>
                                    <label class="form-check-label" for="kidney_diseases">Kidney
                                        Diseases</label>
                                    <br>
                                    <!-- Liver Disease -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['liver_disease']; ?>" id="liver_disease"
                                        name="liver_disease" disabled>
                                    <label class="form-check-label" for="liver_disease">Liver
                                        Disease</label>
                                    <br>
                                    <!-- Thyroid Problem -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['thyroid_problem']; ?>" id="thyroid_problem"
                                        name="thyroid_problem" disabled>
                                    <label class="form-check-label" for="thyroid_problem">Thyroid
                                        Problem</label>
                                    <br>
                                    <!-- Bronchitis -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['bronchitis']; ?>"
                                        id="bronchitis" name="bronchitis" disabled>
                                    <label class="form-check-label" for="bronchitis">Bronchitis</label>
                                    <br>
                                    <!-- Cancer/Tumor -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['cancer_tumor']; ?>"
                                        id="cancer_tumor" name="cancer_tumor" disabled>
                                    <label class="form-check-label" for="cancer_tumor">Cancer/Tumor</label>
                                    <br>
                                    <!-- Anemia -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['anemia']; ?>"
                                        id="anemia" name="anemia" disabled>
                                    <label class="form-check-label" for="anemia">Anemia</label>
                                    <br>
                                    <!-- Angina Pectoris -->
                                    <input class="form-control" type="text"
                                        value="<?php echo $question_row['angina_pectoris']; ?>" id="angina_pectoris"
                                        name="angina_pectoris" disabled>
                                    <label class="form-check-label" for="angina_pectoris">Angina
                                        Pectoris</label>
                                    <br>
                                    <!-- Asthma -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['asthma']; ?>"
                                        id="asthma" name="asthma" disabled>
                                    <label class="form-check-label" for="asthma">Asthma</label>
                                    <br>
                                    <!-- Emphysema -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['emphysema']; ?>"
                                        id="emphysema" name="emphysema" disabled>
                                    <label class="form-check-label" for="emphysema">Emphysema</label>
                                    <br>
                                    <!-- Diabetes -->
                                    <input class="form-control" type="text" value="<?php echo $question_row['diabetes']; ?>"
                                        id="diabetes" name="diabetes" disabled>
                                    <label class="form-check-label" for="diabetes">Diabetes</label>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <!-- Other -->
                        <?php if (!empty($question_row['other_diseases'])) { ?>
                            <input type="text" class="form-control" id="sub_question"
                                value="<?php echo $question_row['other_diseases']; ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="No specify in your Other Diseases"
                                disabled>
                        <?php }
                        ?>
                        <label class="form-check-label" for="other_diseases">Other</label><br>
                        <div id="other_diseases_input" style="display: none;">
                            <label class="form-label" for="other_diseases_text">Please
                                specify any other diseases:</label>
                            <input class="form-control" type="text" id="other_diseases_text" name="other_diseases_text">
                        </div>
                    </div>
                    <?php
                    if ($member_row['gender'] == 'female') { ?>
                        <h3>
                            this part for female.
                        </h3>

                        <label class="form-label" for="question_ten">
                            Are you pregnant?
                        </label>
                        <?php
                        if ($member_row['gender'] == 'female') { ?>
                            <input type="text" class="form-control" id="sub_question" value="<?php echo $question_row['pregnant']; ?>"
                                disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="Not pregnant" disabled>
                        <?php }
                        ?>
                        <br>
                        <label class="form-label" for="pregnancy_months">
                            Pregnancy Months
                        </label>
                        <?php
                        if ($member_row['gender'] == 'female') { ?>
                            <input type="text" class="form-control" id="sub_question"
                                value="<?php echo $question_row['pregnancy_months']; ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="Not pregnant!" disabled>
                        <?php }
                        ?>
                        <br>
                        <label class="form-label" for="question_eleven">
                            Are you currently nursing?
                        </label>
                        <?php
                        if ($member_row['gender'] == 'female') { ?>
                            <input type="text" class="form-control" id="sub_question" value="<?php echo $question_row['nursing']; ?>"
                                disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="Not nursing!" disabled>
                        <?php }
                        ?>
                        <br>
                        <label class="form-label" for="question_twelve">
                            Are you currently taking birth control pills?
                        </label>
                        <?php if ($member_row['gender'] == 'female') { ?>
                            <input type="text" class="form-control" id="sub_question"
                                value="<?php echo $question_row['birth_control']; ?>" disabled>
                        <?php } else { ?>
                            <input type="text" class="form-control" id="sub_question" value="Not using birth_control!" disabled>
                        <?php }
                        ?>
                    <?php } ?>
                </div>
                <hr>
            <?php } else { ?>
                <div class="alert alert-primary">
                    Sorry! but its seems it does not have an medical Information
                </div>
            </div>
        <?php }
    } ?>