<?php
/*
 * This file inserts a newly written prescription into the database. 
 * The file is called from "newprescription.php". 
 * It returns 1 if the insert query was run correctly, otherwise it returns 0
 */


// load functions
require_once('../../functions.php');

// database connection
$dbConnect=  connectDatabase();

// variables to insert
$activeingredient=mysqli_real_escape_string($dbConnect, $_POST['activeingredientID']);
$dosage=mysqli_real_escape_string($dbConnect, $_POST['dosage']);
$dosageunitID=mysqli_real_escape_string($dbConnect, $_POST['dosageunitID']);
$dosageformID=mysqli_real_escape_string($dbConnect, $_POST['dosageformID']);
$frequency=mysqli_real_escape_string($dbConnect, $_POST['frequency']);
$frequencyunitID=mysqli_real_escape_string($dbConnect, $_POST['frequencyunitID']);
$prescriber=mysqli_real_escape_string($dbConnect, $_POST['prescriber']);
$prescriptionExpiry= mysqli_real_escape_string($dbConnect, $_POST['expires']);
$instructions=mysqli_real_escape_string($dbConnect, $_POST['instructions']);
$repeats=mysqli_real_escape_string($dbConnect, $_POST['repeats']);
$repeatsleft=mysqli_real_escape_string($dbConnect, $_POST['repeats']);
$patientID=mysqli_real_escape_string($dbConnect, $_POST['patientID']);


// sql query
$sql = "INSERT INTO prescription (
`prescriptionID`, `activeingredient`, `dosage`, `dosageunitID`, `dosageformID`, `frequency`, `frequencyunitID`, `prescriber`, `prescriptionExpiry`, `instructions`, `repeats`, `repeatsleft`, `active`, `patientID`,`date`)
VALUES
(NULL, '".$activeingredient."', '".$dosage."', '".$dosageunitID."', ".$dosageformID.", '".$frequency."', '".$frequencyunitID."', '".$prescriber."', STR_TO_DATE('".$prescriptionExpiry."','%d.%m.%Y'), '".$instructions."', '".$repeats."', '".$repeats."', '1', '".$patientID."', NULL)";
                                                                                                                                                     //  STR_TO_DATE('1-01-2012', '%d-%m-%Y')                           
 
// execute sql query
$result = $dbConnect->query($sql) Or 
                                die ($error = "Unable to execute the query Error code ".($dbConnect->error));

// output result
echo $result;
mysqli_close($dbConnect);

