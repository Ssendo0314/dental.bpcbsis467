<?php
// Include Composer autoload
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../dbcon.php';

use Dompdf\Dompdf;

// Create a new Dompdf instance
$dompdf = new Dompdf();

// HTML content
$html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Consent Form for Dental Treatment">
    <meta name="author" content="Your Name">

    <title>Consent Form - Dental Treatment</title>

</head>

<body class="sb-nav-fixed">
    <hr><br>
    <div class="container">
        <!-- Header -->
        <div class="row">
            <h3>DR. L.B. DE GUZMAN DENTAL CLINIC</h3>
        </div>
        <!-- Body -->
        <div class="row">
            <!-- Main Body -->
            <div class="col-xl-12">
                <main>
                    <!-- Consent Form content -->
                    <p><strong>______ TREATMENT TO BE DONE.</strong> I understand and consent to have any treatment
                        done by the dentist
                        after the procedure, the risks & benefits & cost have been fully explained. These treatments
                        include, but are not limited to, x-rays, cleanings, periodontal treatments, fillings, crowns,
                        bridges, all types of extraction, root canals & for dentures, local anesthetics & surgical
                        cases.
                    </p>
                    <p>
                        <strong> ______CHANGES TO TREATMENT PLAN.</strong> I understand that during treatment it may be
                        necessary to change/add procedures because of conditions found while working on the teeth that
                        were not
                        discovered during examination. For example, root canal therapy may be needed following routine
                        restorative procedures. I give my permission to the dentist to make any/all changes and
                        additions as
                        necessary w/my responsibility to pay all the costs agreed.
                    </p>
                    <p>
                        <strong>______ RADIOGRAPHS.</strong> I understand that an x-ray shot or a radiograph may be
                        necessary as part of
                        diagnostic and to come up with tentative diagnosis of my dental problem and to make a good
                        treatment
                        plan, but this will not give me a 100% assurance for the accuracy of the treatment since all
                        dental
                        treatments are subjected to unpredictable complications that later on may lead to sudden change
                        of
                        treatment plan and subject to the new charges.
                    </p>
                    <p>
                        <strong> ______REMOVAL OF TEETH.</strong> I understand that alternatives to tooth removal (root
                        canal therapy,
                        crowns
                        & periodontal surgery, etc.) & I completely understand these situations including their risk &
                        benefits prior to authorizing the dentist to remove teeth and & any other structures necessary
                        for
                        reasons above. I understand that removing teeth does not always remove the infections, if
                        present
                        and it may be necessary to have further treatment. I understand the risk involved in having
                        teeth
                        removed, such as pain, swelling, and spread of infection, dry socket, and fractured jaw, loss of
                        feeling on the teeth, lips, tongue & surrounding tissue that can last for an indefinite period.
                        I
                        understand that I may need further treatment under a specialist if complications may arise
                        during or
                        following treatment.
                    </p>
                    <p>
                        <strong>______ CROWNS AND BRIDGE.</strong> Preparing a tooth may irritate the nerve tissue in
                        the center of the
                        tooth, leaving the tooth extra sensitive to heat, cold & pressure. Treating such irritation may
                        involve using special toothpaste, mouth rinse or root canal therapy. I understand that sometimes
                        it
                        is not possible to match the color of natural teeth exactly with artificial teeth. I further
                        understand that I may be wearing temporary crowns, which may come off easily & that I must be
                        careful to ensure that they are kept on until the permanent crowns are delivered. It is my
                        responsibility to return for permanent cementation within 20 days from tooth preparation, as
                        excessive days delay may allow tooth movement, which may necessitate a remake of the crown,
                        bridge/cap. I understand there will be additional charges for remakes due to my delaying of
                        permanent cementation, & I realize that final opportunity to make changes in my crown,
                        bridges/cap
                        (including shape, fit, size & color) will be before permanent cementation.
                    </p>
                    <p>
                        <strong>______ ENDODONTIC.</strong> I understand there is no guarantee that a root canal
                        treatment will save a
                        tooth
                        & that complication can occur from the treatment, that occasionally root canal filling materials
                        may
                        extend through the tooth which does not necessarily affect the success of the treatment. I
                        understand that endodontic files & drills are very fine instruments & stresses vented in their
                        manufacture & calcifications present in teeth may cause them to break during use, I understand
                        that
                        referral to the endodontist for additional treatments may be necessary following any root canal
                        treatment & I agree that I am responsible for any additional cost for treatment performed by the
                        endodontist. I understand that a tooth may require removal despite all efforts to save it.
                    </p>
                    <p>
                        <strong>______ PERIODONTAL DISEASE.</strong> I understand that periodontal disease is a serious
                        condition causing
                        gum
                        and bone inflammation & or loss & that can lead eventually to the loss of my teeth. I understand
                        the
                        alternative treatment plans to correct periodontal disease, including gum surgery, tooth
                        extractions
                        with or without replacement. I understand that undertaking any dental procedures may have future
                        adverse effects on my periodontal conditions.
                    </p>
                    <p>
                        <strong>______ RESTORATIVE FILLINGS.</strong> I understand that care must be exercised in
                        chewing on fillings,
                        especially during the first 24 hours to avoid breakage. I understand that a more extensive
                        filling
                        or a crown may be required, as additional decay or fracture may become evident after initial
                        excavation. I understand that significant sensitivity is a common, but usually after effect of a
                        newly placed filling. I further understand that filling a tooth may irritate the nerve tissue.
                    </p>
                    <p>
                        <strong>______ DENTURES.</strong> I understand that wearing of dentures can be difficult. Canker
                        sores, altered
                        speech & difficulty in eating are common problems. Immediate dentures (placement of dentures
                        immediately after extractions) may be painful. Immediate dentures may require considerable
                        adjusting
                        & several relines. I understand that it is my responsibility to return for the delivery of
                        dentures.
                        I understand that failure to keep my delivery appointment may result in poorly fitted dentures.
                        If a
                        remake is required due to my delays of more than 30 days, there will be additional charges. A
                        permanent reline will be needed later, which is not included in the initial fee. I understand
                        that
                        all adjustments/alterations after this initial period are subject to charges.
                    </p>
                    <p>
                        <strong> ______ DRUGS AND MEDICATION.</strong> I understand that antibiotics, analgesics & other
                        medications can
                        cause
                        allergic reactions like redness & swelling of tissues, pain, itching, vomiting, & or
                        anaphylactic
                        shock. I understand that dentistry is not an exact science and that no dentist can properly
                        guarantee accuracy. I hereby authorize any of the doctors/dental auxiliaries to proceed with &
                        perform the dental treatments as explained to me. I understand that these are subject to
                        modification depending on un-diagnosable circumstances that may arise during treatment. I
                        understand
                        that regardless of any insurance that I have, I am responsible for payment of dental fees. I
                        agree
                        to pay attorney s fees, collection fee, or court costs that may be incurred to satisfy any
                        obligation to this office. All treatments were properly explained to me & any untoward
                        circumstances
                        that may arise during the procedure, the attending dentist will not be held liable since it is
                        my
                        free will, with full trust & confidence in him/her to undergo dental treatment under his/her
                        care.
                    </p>
                    <br>
                    <p>Last updated: <strong>November 09, 2023</strong></p>
                    <br>
                    <div class="row">
                        <div class="row">
                            <div class="col-8 col-sm-3">
                                <strong>Patient/ Parent Gruardian s Signature</strong>
                            </div>
                            <div class="col-4 col-sm-6">
                                ________________________________________________
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 col-sm-3">
                                <strong>Date</strong>
                            </div>
                            <div class="col-4 col-sm-6">
                                ________________________________________________
                            </div>
                        </div>
                    </div>
            </div>
            </main>
        </div>
    </div>
    </div>
</body>

</html>';

// Load HTML to Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

$dompdf->set_option('marginLeft', 'auto');
$dompdf->set_option('marginRight', 'auto');
$dompdf->set_option('marginTop', 'auto');
$dompdf->set_option('marginBottom', 'auto');

// Render PDF (generate PDF)
$dompdf->render();

// Output PDF to browser
$dompdf->stream("user_information.pdf", array("Attachment" => false));
?>