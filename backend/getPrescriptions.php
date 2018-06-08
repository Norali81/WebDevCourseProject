<?php
/*
 * This file is used to generate the prescription table
 * It retrieve's all presriptions of a particular patient from the database
 * and outputs, formats them into html code and returns the html code to the frontend. 
 * The frontend then just shows this code
 */
// under construction
require_once('../functions.php');

// connect to database
$dbConnect=  connectDatabase();

// get patient ID and role
$patientID = $_POST['patientID'];
$role =  $_POST['role'];

// query
$sql = "SELECT 
prescription.prescriptionID, 
activeingredient.name, 
prescription.date,
prescription.dosage, 
units.name as dosageunit, 
dosageform.name as dosageformname, 
user.firstname, 
user.lastname, 
prescription.repeats, 
prescription.repeatsleft, 
prescription.frequency, 
frequencyunits.name as funitName,
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
WHERE prescription.patientID=".$patientID."
ORDER BY prescription.date DESC";
     
// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");
   
// declare string variable
$string="";


// add table header to string variable
$string = "<div class='presTable'> <table class='presHistory' id='presHistory'>
            <tr class='trpresHistory'>
                <th class='select'>Select</th>
                <th class='presHistory'>ID</th>
                <th class='presHistory'>Date</th>
                <th class='presHistory'>Medication</th>
                <th class='presHistory'>Dosage</th>
                <th class='presHistory'>Dosageform</th>
                <th class='presHistory'>Active</th>
                <th class='presHistory'>Prescriber</th>
                <th class='presHistory'>Frequency</th>
                <th class='presHistory'>Instructions</th>
                <th class='presHistory'>Expires</th>
                <th class='presHistory'>Last dispensed</th>
                <th class='presHistory'>Repeats</th>
                <th class='presHistory'>Rep. remain</th>
            </tr>";

// fetch line by line from all prescritpions returned from the database
while ($row = $result -> fetch_object()) {
   
    // if active is one, display yes, if 0 display no
    $active= $row->active==1?"yes":"no";
    
    // format date correctly
    $date = date('d.m.y', strtotime($row->date));
    
    // execute query to get the date when the prescription was last dispensed
    $lastDispensed = getLastDispensed($row->prescriptionID, $dbConnect);
    
    // put each row into a html table row
    $string .= 
            "
             <tr class='trpresHistory'>
                <td class='select'> <input type='radio' id='optionSelect' name='prescription' onclick='changeButton()' value=".$row->prescriptionID."></td>
                <td class='presHistory'>".$row->prescriptionID."</td>
                <td class='presHistory'>".$date."</td>
                <td class='presHistory'>".$row->name."</td>
                <td class='presHistory'>".$row->dosage." ".$row->dosageunit."</td>
                <td class='presHistory'>".$row->dosageformname."</td>
                <td class='presHistory'>".$active."</td>
                <td class='presHistory'>".$row->firstname."<br>".$row->lastname."</td>
                <td class='presHistory'>".$row->frequency."<br>".$row->funitName."</td>
                <td class='presHistory'>".$row->instructions."</td>
                <td class='presHistory'>".$row->prescriptionExpiry."</td>
                <td class='presHistory'>".$lastDispensed."</td>
                <td class='presHistory'>".$row->repeats."</td>
                <td class='presHistory'>".$row->repeatsleft."</td>
            </tr>
            ";  
}
$string .="</table></div><br>";

// depending on the role, display different buttons
if ($role==='doc') {
        //. "<button class='renewButton' type='button' onclick='renew()'>renew</button>"
        $string .= "<button class='newButton' type='button' id='newButton' onclick='newPrescription(".$patientID.")'>new prescription</button>";
} else if ($role==='pha') {
        $string .= "<button class='newButton' type='button' onclick='dispensePrescription(".$patientID.")'>dispense selected</button>";
} else {
    echo "there was an error determining the role";
}

// return string to frontend
echo $string;

// free result and close connection
$result->free();
mysqli_close($dbConnect);
