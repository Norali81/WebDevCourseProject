<?php
/*
 * This file is used for the autocompletion of the html input forms
 * when writing a new prescription or new dispensal. 
 * It returns a json array of items that are populated in a drop down 
 * by the frontend
 */

// load functions
require_once('../../functions.php');

// get the search term entered by the user
$searchTerm = $_GET['term'];


// connect to database 
$dbConnect=  connectDatabase();

// Change character set to utf8 for correct represenatation of the microgram sign µg
mysqli_set_charset($dbConnect,"utf8");

// query
$sql="SELECT dosageformid, name as label FROM dosageform WHERE name like '%".$searchTerm."%'";

// execute query
$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

// encode to JSON format
$output = json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));

// return output 
echo $output;

// close connection
mysqli_close($dbConnect);

