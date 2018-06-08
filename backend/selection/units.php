<?php
/*
 * This file is used for the autocompletion of the html input forms
 * when writing a new prescription or new dispensal. 
 * It returns a json array of items that are populated in a drop down 
 * by the frontend
 */

// require script with functions
require_once('../../functions.php');

// connect to database (see functions.php)
$dbConnect=  connectDatabase();

// Change character set to utf8
mysqli_set_charset($dbConnect,"utf8");

// query
$sql="SELECT unitID, name as label FROM units"; 

// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

// JSON encode result
$output = json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));

// output result 
echo $output;

// close connection
mysqli_close($dbConnect);

