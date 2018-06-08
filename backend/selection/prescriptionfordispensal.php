<?php
// retrieve list of activeingredients in db 
// this is to populate in the autocomplete dropdown of the 'new prescripion' functionality

// require necessary scripts
require_once('../../functions.php');
require_once('../../classes.php');

// get prescription ID
$presID = $_POST['presID'];

// connect to database
$dbConnect=  connectDatabase();
// write query
$sql="SELECT prescription.activeingredient, activeingredient.name FROM prescription
      INNER JOIN activeingredient 
      ON prescription.activeingredient = activeingredient.activeingredientID
      WHERE prescription.prescriptionID =".$presID.";";

// echo $sql;
// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

// fetch all results as associative array
$output = json_encode(mysqli_fetch_assoc($result));

// return output
echo $output;

// free result
mysqli_free_result ($result);

// close connection
mysqli_close($dbConnect);
