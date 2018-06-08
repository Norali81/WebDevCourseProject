<?php
// retrieve list of generics in db 
// this is to populate in the autocomplete dropdown of the 'new prescripion' functionality

// require necessary scripts
require_once('../../functions.php');

// get active ingredient so that we can search for generic by activeingredientID
$activeingredientID = $_GET['activeingredientID'];

// connect to database
$dbConnect=  connectDatabase();
// write query
$sql="SELECT genericdrugID, genericName as label FROM genericDrug WHERE activeingredientID=".$activeingredientID;
//echo $sql;
// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

// fetch all results as associative array
$output = json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));

// return output
echo $output;

// free result
mysqli_free_result ($result);

// close connection
mysqli_close($dbConnect);
