<!-- Style for the input fields and their autocomplete box-->
<!-- This code was taken from https://jqueryui.com/resources/demos/autocomplete/combobox.html -->

<?php
$presID= $_GET['presID'];
$patientID= $_GET['patientID'];

?>

<script type="text/javascript">
    
    
var presID = '<?php echo $presID; ?>';
var patientID = '<?php echo $patientID; ?>';

$.ajax({
            type:"POST",
            url:"backend/selection/prescriptionfordispensal.php",
            data: ({patientID: patientID, presID:presID}),
            cache: false, 
            success: function(data) {
            var response= JSON.parse(data);
            console.log(response);
            $('#activeingredient').val(response.name);
            $('#activeingredientID').val(response.activeingredient);
            }
        })
        .fail(function() {
             alert('Something went wrong. Can\'t load prescription data\n Please contact an administrator' + response);
        });
       
      
 // retrieve the list of generic drugs from the database
    $("#genericname").autocomplete({
        // backend script that delivers list of generics
        source: function(request, response) {
                $.getJSON("./backend/selection/generics.php", { activeingredientID:$('#activeingredientID').val() }
                , response);
        },
        // length after which autocomplete starts
        minLength: 1,
        select: function (event, ui) {
        // store ID value of generic in hidden field
        // name value gets populated in visible field automatically
        $(":hidden#genericID").val(ui.item.genericdrugID);
        },
        change: function (event, ui) {
            if (!ui.item) {
                // if the item is not one from the list, clear the field
                $("#genericname").val("");
                // also clear hidden ID field
                $(":hidden#genericID").val("");
            }
        }
});

 $("#strengthunit").autocomplete({
            source: "./backend/selection/units.php",
            minLength: 1,
            select: function (event, ui) {
                $(":hidden#strengthunitID").val(ui.item.unitID);
            },
            change: function (event, ui) {
                if (!ui.item) {
                    // if the item is not one from the list, clear the field
                    $("#strengthunit").val("");
                    $(":hidden#strengthunitID").val("");
                }
            }
        });


 // function to be executed when 'new prescription' form is submitted
    $("#dispensalForm").submit(function (e) {
        // url of backend script that will handle the input into the database   
        var url = "backend/insert/dispensal.php";
        // validate function to check if all user input is valid. The validate function is further down in this file. 
        if (validate() === true) {
            // make ajax request to the script prescription.php to retrieve all the patient's prescriptions
            $.ajax({
                type: "POST",
                url: url,
                // serializes the form's elements.(create URL encoded string)
                data: $("#dispensalForm").serialize(),
                success: function (data)
                {
                    // if response from script is 1, data was successfully saved. 
                    if (data == "Dispensal stored correctly") {
                        console.log(data);
                        alert("Dispensal successfully saved");
                        // reload prescription table
                        loadPrescriptions(patientID, role);
                        // blank new prescription <div> 
                        $("#dispensePrescription").empty();
                        
                    } else if(data=="No repeats left or prescription expired") {
                        alert("No repeats left or prescription expired. Nothing dispensed");
                    } else {
                        // else something went wrog. Alert user and log response to console
                        alert("Something went wrong. Please contact us."); // show response from the php script.
                        console.log(data);
                        console.log(typeof (data));
                    }
                },
                complete: function(response, textStatus) {
                   // return alert("Submit: " + textStatus);
                }
            });


        }
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

 function validate() {
        var validate = true;
        var errorString = "";

        // validate GenericName
        if (validateInt(document.dispensalForm.genericID.value) === false) {
            errorString += "Please select a generic medication <br>";
            validate = false;
        }

        // validate strength
        if (isNaN(document.dispensalForm.strength.value)) {
            errorString += "Strength must contain a number with a point decimal separator <br>";
            validate = false;
        }
        // validate dosageUnitID
        if (validateInt(document.dispensalForm.strengthunitID.value) === false) {
            errorString += "Please select a strength unit <br>";
            validate = false;
        }
        // Frequency and frequency unit will not be evaluated because they're optional
        // Program should already enforce frequency unit to be blanked if invalid

      
        document.getElementById("errorMessage").innerHTML = errorString;
        return validate;

    }
   


</script>



<div class="ui-widget">
<img src="./images/help.jpg" alt="help" id="tooltip" class="tooltip" title="Start typing and then select an item from each field">
    <form name='dispensalForm' action="backend/insert/dispensal.php" id="dispensalForm" method="POST">
        <table>
            <tr>
                <td>PatientID:</td>
                <td> PrescriptionID:</td>
                <td><input name='pharmacistid' id='pharmacistid' type='hidden' value=''></td>
                <td></td>
            </tr>
            <tr>
                <td><input name='patientID' id='patientID' type='text' value='' size='6' readonly></td>
                <td><input name='prescriptionID' id='prescriptionID' type='text' value='' size='6' readonly></td>
                <td></td>
                <td></td>
            </tr> 
            <tr>
                <td colspan='3'><label for='activeingredient'>Drug name: </label></td>
                <td></td>
            </tr>
            <tr>
                <td colspan='3'><input name='activeingredient' id='activeingredient' type='text' readonly value=''>
                    <input name='activeingredientID' id='activeingredientID' type='hidden' value=''> </td>
                <td></td>
            </tr>
            <tr>
                <td colspan='3'><label for='genericname'>Generic Name: </label></td>
                <td></td>
            </tr>
            <tr>
                <td colspan='3'><input name='genericname' id='genericname' type='text' value=''>
                    <input name='genericID' id='genericID' type='hidden' value=''> </td>
                <td></td>
            </tr>
            <tr>
                <td><label for='strength'>Strength: </label></td>
                <td><label for='strengthunit'>Unit: </label></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><input name='strength' id='strength' type='text' value='' size='5'></td>
                <td><input name='strengthunit' id='strengthunit' type='text' size='5' value=''>
                    <input name='strengthunitID' id='strengthunitID' type='hidden' value=''></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan='3'><label for='instructions'>Instructions: </label></td>
                <td></td>
            </tr>
            <tr>
                <td colspan='4'>
                    <textarea id='instructions' name='instructions' form='dispensalForm' cols='20' rows='3'> </textarea></td>
            </tr>
        </table>
        <p id="errorMessage"> </p>
        <input type='submit' value='submit' onsubmit='return validate ()'>
    </form>
</div>

<script type="text/javascript">
    // set hidden input field to correct user ID so 
    document.getElementById('pharmacistid').value = userID;
</script>

