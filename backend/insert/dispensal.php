<?php

/*
 * This file is used to insert a new dispensal into the database. 
 * It is called by "dispenseprescription.php"
 * It returns either an error message or "Dispensal stored correctly" 
 */

// load functions
require_once('../../functions.php');

// database connection
$dbConnect=  connectDatabase();

// variables to insert
$pharmacistID=mysqli_real_escape_string($dbConnect, $_POST['pharmacistid']);
$prescriptionID=mysqli_real_escape_string($dbConnect, $_POST['prescriptionID']);
$genericID=mysqli_real_escape_string($dbConnect, $_POST['genericID']);
$strength=mysqli_real_escape_string($dbConnect, $_POST['strength']);
$strengthunitID=mysqli_real_escape_string($dbConnect, $_POST['strengthunitID']);
$pharmacistinstructions=mysqli_real_escape_string($dbConnect, $_POST['instructions']);

// sql queries
$sqlRepeats = "SELECT repeatsleft, prescriptionExpiry FROM prescription WHERE prescriptionID=".$prescriptionID;

$sql = "INSERT INTO `dispensal` (`dispensalID`, `prescriptionID`, `pharmacistID`, `genericID`, `strength`, `strengthunitID`, `pharmacistinstructions`) VALUES 
(NULL, '".$prescriptionID."', '".$pharmacistID."', '".$genericID."', ".$strength.", '".$strengthunitID."', '".$pharmacistinstructions."')";

$sqlRepeatsUpdate="Update prescription SET repeatsleft=(repeatsleft-1) WHERE prescriptionID=".$prescriptionID;
$sqlRepeatsUpdate2="Update prescription SET repeatsleft=(repeatsleft-1), active='false' WHERE prescriptionID=".$prescriptionID;

// error string
$error="";

// check how many repeats left
$result = $dbConnect->query($sqlRepeats) Or 
                                die ($error .= "\nUnable to execute the query Error code ".($dbConnect->error));
// fetch number of repeats
$repeats = mysqli_fetch_row($result);
// free result
mysqli_free_result($result);

// setting date today
$today = date("Y-m-d");
//echo "today".$today;
//echo "expires".$repeats[1];
//echo "which is greater";
//echo $repeats[1]>$today;

// if there are repeats left & the prescription is not expired, proceed
if ($repeats[0]>0 && ($repeats[1]>$today ||$repeats[1]==null )) {
    // execute query to update prescription table
    $resultMain = $dbConnect->query($sql) Or 
                                die ($error .= "\nUnable to execute the query Error code ".($dbConnect->error));
    
    // if successfully update prescription table
    if ($resultMain) {
        // if this was the last repeat
        if ($repeats[0]==1) {
            // set repeats to 0 and set prescription to inactive
            $result = $dbConnect->query($sqlRepeatsUpdate2) Or 
                                die ($error .= "\nUnable to execute the query Error code ".($dbConnect->error)); 
        } else {
            // decrement repeats by 1
            $result = $dbConnect->query($sqlRepeatsUpdate) Or 
                                die ($error .= "\nUnable to execute the query Error code ".($dbConnect->error)); 
        
            //echo "affected rows" . mysqli_affected_rows($dbConnect);
        }
        // store success in error string
        if (mysqli_affected_rows($dbConnect)>0) {
            $error.= "Dispensal stored correctly";
        }
    } 
// if there are no repeats left, stop
} else {
   $error.="No repeats left or prescription expired"; 
}
// output result
echo $error;

// close connection
mysqli_close($dbConnect);