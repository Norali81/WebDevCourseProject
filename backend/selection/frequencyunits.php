<?php
/*
 * This file is used for the autocompletion of the html input forms
 * when writing a new prescription or new dispensal. 
 * It returns a json array of items that are populated in a drop down 
 * by the frontend
 */

// load functions
require_once('../../functions.php');

// connect to database
$dbConnect=  connectDatabase();

// Change character set to utf8 
mysqli_set_charset($dbConnect,"utf8");

// query 
$sql="SELECT frequencyunitID, name as label FROM frequencyunits";

// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

//JSON encode result
$output = json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));

// output result
echo $output;

// close connection
mysqli_close($dbConnect);

