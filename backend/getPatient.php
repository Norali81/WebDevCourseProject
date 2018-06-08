<?php

/*
 * This script is used by the function searchPatient() in the functions.js file
 * It retrives the details about a patient and returns them to the frontend
 * it returns 0 if no patient is found, -1 if several are found and the patient data
 * if exactly one is found (which is the desired result). 
 */

// load functions
require_once('../functions.php');

// connect to database. 
$dbConnect=  connectDatabase();

$patientID = htmlspecialchars($_POST['patientID']);

//  query
$sql = "SELECT user.firstname, user.lastname, patient.dob 
FROM user INNER JOIN patient ON user.userID=patient.userID
WHERE user.userID=".$patientID;

// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");
// get result
$numRows= $result->num_rows;

// if result is available
if ($numRows == 0) {
     echo 0;  
} elseif ($numRows>1) {
    echo -1;
} elseif ($numRows===1) {
    $row = json_encode($result->fetch_assoc());
    echo $row;
    
}
$result->free();	

