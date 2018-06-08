<!-- 
This file is loaded when a doctor clicks the "new prescription" button. 
It displays a html form to fill in a new prescription. 
Several fields in the form have autocomplete functionality. 


The autocomplete functionality wasn't written by us, it is a module available at
https://jqueryui.com/autocomplete/

This file also handles input validation 
--> 

<script type="text/javascript">
    // Style the datepicker to European format
    $(function () {
        $("#datepicker").datepicker({dateFormat: "dd.mm.yy"}).val();
    });
     
</script>

<?php
// require functions and the one, lonely class
require_once('./functions.php');
require_once('./classes.php');


/* 
 * In case the doctor had selected a checkbox in the prescription table to renew a prescription
 * The relevant info from the old prescripiton has to be copied into the prescription form
 * getting the information from the database and adding it to the prescripion html form
 */

// if a prescription was selected
if (isset($_GET['prescriptionID'])){ 
        $prescriptionID = $_GET['prescriptionID'];
    }

// store the ID in a variable
if (isset($prescriptionID)) {
    
    // connect to database and execute query
    $dbConnect = connectDatabase();
    $sql = "SELECT 
        prescription.prescriptionID, 
        activeingredient.name, 
        prescription.activeingredient,
        prescription.date,
        prescription.dosage, 
        units.name as dosageunit, 
        prescription.dosageunitID,
        dosageform.name as dosageformname, 
        prescription.dosageformID,
        user.firstname, 
        user.lastname, 
        prescription.repeats, 
        prescription.repeatsleft, 
        prescription.frequency, 
        frequencyunits.name as funitName,
        prescription.frequencyunitID,
        prescription.instructions, 
        prescription.prescriptionExpiry,
        prescription.active 
        FROM prescription
        INNER JOIN activeingredient
        ON prescription.activeingredient = activeingredient.activeingredientID
        INNER JOIN dosageform
        ON prescription.dosageformID = dosageform.dosageformid
        INNER JOIN user
        ON prescription.prescriber = user.userID
        INNER JOIN frequencyunits
        ON prescription.frequencyunitID = frequencyunits.frequencyunitID
        INNER JOIN units
        ON prescription.dosageunitID = units.unitID
        WHERE prescriptionID=".$prescriptionID;


    // execute sql query
    $result = $dbConnect->query($sql) Or 
                                die ($error = "Unable to execute the query Error code ".($dbConnect->error));
    
    // store result in associative array
    $row = json_encode(mysqli_fetch_assoc($result));
    
    // close connection
    $dbConnect->close();

} else {
    // else store 0 in $ row to identify no item had been selected
    $row=0;
}


?>





<script>

// store JSON encoded query result in variable
var renewPrescriptionArray = JSON.parse('<?php echo $row?>');

// populate data in HTML input fields
if (renewPrescriptionArray !==0) {
    console.log("Hello " + renewPrescriptionArray.activeingredient);
    console.log("Hello " + renewPrescriptionArray.name);
    $('#drugName').val(renewPrescriptionArray.name);
    $('#activeingredientID').val(renewPrescriptionArray.activeingredient);
    $('#dosage').val(renewPrescriptionArray.dosage);
    $('#dosageunit').val(renewPrescriptionArray.dosageunit);
    $('#dosageunitID').val(renewPrescriptionArray.dosageunitID);
    $('#frequency').val(renewPrescriptionArray.frequency);
    $('#frequencyunit').val(renewPrescriptionArray.funitName);
    $('#frequencyunitID').val(renewPrescriptionArray.frequencyunitID);
    $('#dosageform').val(renewPrescriptionArray.dosageformname);
    $('#dosageformID').val(renewPrescriptionArray.dosageformID);
    $('#instructions').val(renewPrescriptionArray.instructions);
}


    // Autocomplete function for the html input fields of 'new prescription'
    // code inspred by https://jqueryui.com/autocomplete/
    $(function () {

        // retrieve the list of activeingredients from the database
        $("#drugName").autocomplete({
            // backend script that delivers list of activeingredients
            source: "./backend/selection/drugs.php",
            // length after which autocomplete starts
            minLength: 2,
            select: function (event, ui) {
                // store ID value of active ingredient in hidden field
                // name value gets populated in visible field automatically
                $(":hidden#activeingredientID").val(ui.item.activeingredientID);
            },
            change: function (event, ui) {
                if (!ui.item) {
                    // if the item is not one from the list, clear the field
                    $("#drugName").val("");
                    // also clear hidden ID field
                    $(":hidden#activeingredientID").val("");
                }
            }
        });

        // for info on usage see comments in  $( "#drugName" ).autocomplete field
        $("#dosageunit").autocomplete({
            source: "./backend/selection/units.php",
            minLength: 0,
            select: function (event, ui) {
                $(":hidden#dosageunitID").val(ui.item.unitID);
            },
            change: function (event, ui) {
                if (!ui.item) {
                    // if the item is not one from the list, clear the field
                    $("#dosageunit").val("");
                    $(":hidden#dosageunitID").val("");
                }
            }
        });

        // for info on usage see comments in  $( "#drugName" ).autocomplete field
        $("#dosageform").autocomplete({
            source: "./backend/selection/dosageform.php",
            minLength: 0,
            select: function (event, ui) {
                $(":hidden#dosageformID").val(ui.item.dosageformid);
            },
            change: function (event, ui) {
                if (!ui.item) {
                    // if the item is not one from the list, clear the field
                    $("#dosageform").val("");
                    $(":hidden#dosageformID").val("");
                }
            }
        });

        // for info on usage see comments in  $( "#drugName" ).autocomplete field
        $("#frequencyunit").autocomplete({
            source: "./backend/selection/frequencyunits.php",
            minLength: 0,
            select: function (event, ui) {
                $(":hidden#frequencyunitID").val(ui.item.frequencyunitID);
            },
            change: function (event, ui) {
                if (!ui.item) {
                    // if the item is not one from the list, clear the field
                    $("#frequencyunit").val("");
                    $(":hidden#frequencyunitID").val("");
                }
            }
        });
    });

    // function to be executed when 'new prescription' form is submitted
    $("#prescriptionForm").submit(function (e) {
        // url of backend script that will handle the input into the database   
        var url = "backend/insert/prescription.php";
        // validate function to check if all user input is valid. The validate function is further down in this file. 
        if (validate() === true) {
            // make ajax request to the script prescription.php to retrieve all the patient's prescriptions
            $.ajax({
                type: "POST",
                url: url,
                // serializes the form's elements.(create URL encoded string)
                data: $("#prescriptionForm").serialize(),
                success: function (data)
                {
                    // if response from script is 1, data was successfully saved. 
                    if (data == 1) {
                        console.log(data);
                        alert("Prescription successfully saved");
                        // reload prescription table
                        
                        //alert(patientID);
                        loadPrescriptions(patientID, role);
                        // blank new prescription <div> 
                        $("#newPrescription").empty();

                    } else {
                        // else something went wrog. Alert user and log response to console
                        alert("Something went wrong. Please contact us."); // show response from the php script.
                        console.log(data);
                        console.log(typeof (data));
                    }
                }
            });


        }
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


    function validate() {
        var validate = true;
        var errorString = "";

        // validate activeIngredientID
        if (validateInt(document.prescriptionForm.activeingredientID.value) === false) {
            errorString += "Please select a medication <br>";
            validate = false;
        }

        // validate dosage
        if (isNaN(document.prescriptionForm.dosage.value)) {
            errorString += "Dosage must contain a number with a point decimal separator <br>";
            validate = false;
        }
        // validate dosageUnitID
        if (validateInt(document.prescriptionForm.dosageunitID.value) === false) {
            errorString += "Please select a dosage unit <br>";
            validate = false;
        }
        // Frequency and frequency unit will not be evaluated because they're optional
        // Program should already enforce frequency unit to be blanked if invalid

        // validate repeats
        if (validateInt(document.prescriptionForm.repeats.value) === false) {
            errorString += "Repeats must contain a whole number <br>";
            validate = false;
        }
        // validate dosageform
        if ((document.prescriptionForm.dosageform.value) === "") {
            errorString += "Please select a dosage form <br>";
            validate = false;
        }
        document.getElementById("errorMessage").innerHTML = errorString;
        return validate;


    }
    // function to validate if an input is an int
    function validateInt(number) {
        var regexNumber = new RegExp(/^\d+$/);
        return regexNumber.test(number);
    }


</script>
<!-- Display input form in table format --> 
<div class="ui-widget">
    <img src="./images/help.jpg" alt="help" class="tooltip" title="Start typing and then select an item from each field">
    <form name='prescriptionForm' action="backend/insert/prescription.php" id="prescriptionForm" method="POST">
        <table>
            <tr>
                <td>PatientID:</td>
                <td><input name='prescriber' id='prescriber' type='hidden' value=''></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><input name='patientID' id='patientID' type='text' value='' size='6' readonly></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> 
            <tr>
                <td colspan='2'><label for='drugName'>Drug name: </label></td>
                <td><label for='dosage'>Dosage: </label></td>
                <td><label for='dosageunit'>Unit: </label></td>
            </tr>
            <tr>
                <td colspan='2'><input name='drugName' id='drugName' type='text' value=''>
                    <input name='activeingredientID' id='activeingredientID' type='hidden' value=''> </td>
                <td><input name='dosage' id='dosage' type='text' value='' size='5'></td>
                <td><input name='dosageunit' id='dosageunit' type='text' size='5' value=''>
                    <input name='dosageunitID' id='dosageunitID' type='hidden' value=''></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><label for='frequency'>Frequency: </label></td>
                <td><label for='frequencyunit'>Freq. Unit: </label></td>
                <td></td>
                <td></td>

            </tr>
            <tr>
                <td><input id='frequency' name='frequency' type='text' value='' size='5'></td>
                <td><input id='frequencyunit' name='frequencyunit' type='text' value='' size='10'>
                    <input id='frequencyunitID' name='frequencyunitID' type='hidden' value=''></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Repeats</td>
                <td>Expires</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><input name='repeats' type='text' value='' size='5'></td>
                <td><input name='expires' type='text' id='datepicker' value='' size='10'></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan='2'><label for='dosageform'>Dosageform: </label></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan='2'><input id='dosageform' name='dosageform' type='text' value='' size='20'>
                    <input id='dosageformID' name='dosageformID' type='hidden' value=''></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan='3'><label for='instructions'>Instructions: </label></td>
                <td></td>
            </tr>
            <tr>
            <td colspan='4'>
                <textarea id='instructions' name='instructions' form='prescriptionForm' cols='20' rows='3'> </textarea>
            </td>
            </tr>
        </table>
        <p id="errorMessage"> </p>
        <input type='submit' value='submit' onsubmit='return validate()'>
    </form>
</div>

<script type="text/javascript">
    // set hidden input field to correct user ID so 
    document.getElementById('prescriber').value = userID;
       

</script>