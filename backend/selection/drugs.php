<?php
// retrieve list of activeingredients in db 
// this is to populate in the autocomplete dropdown of the 'new prescripion' functionality

// require necessary scripts
require_once('../../functions.php');

// get the search term entered by the user
$searchTerm = $_GET['term'];

// connect to database
$dbConnect=  connectDatabase();
// write query
$sql="SELECT activeingredientID, name as label FROM activeingredient WHERE name like '%".$searchTerm."%'";

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
