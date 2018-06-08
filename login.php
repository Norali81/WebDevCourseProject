<?php
// require functions and classes needed
require ('functions.php');
require ('classes.php');


if ( is_session_started() === FALSE ) { 
    session_start();
}

$debug=0;

/*
 * This file handles the login. It contains the form loginform.php which submits to self
 * So the below code handles two case: 
 * 1. The user has not submitted the form yet and is here the first time
 * 2. The user has just submitted the form and we check his username and password in the database. 
 * 
 */

// first, check if the user just just submitted the login form
// by checking if POST variables are available
if (isset($_POST["username"])) {
// get usernames from input form
$username = $_POST["username"];
// hash password 
$password = md5($_POST["password"]);
                // debug statement
                if ($debug==1) {echo "Username: ".$username." Password: ".$password."<br>";}
        // check if username and password both have been submitted, not only one
	if (isset($username) && (!empty($password))) {
                // connect to database
		$dbConnect=connectDatabase();
                // verify if user in database
                 if (verifyUser($username, $password, $dbConnect) == true) {
                    // if user is valid and password correct, send user to index.php
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = getUserRole($dbConnect, $username);
                    $_SESSION["userID"] = getUserID($dbConnect, $username);
                    header( 'Location: index.php' ); 
                 } else{
                     // if password not correct, output message and include loginform again
                     include ('header.php');
                     include ('imagechange.php');
                     echo "Incorrect Password. Please try again<br>";
                     include ('loginform.php');
                   
                 }
        } else {
          // do nothing at the moment
        }
// If the user didn't already submit the login form, load login form which submits to self. 
} else if(isset($_SESSION['role'])) {
    header( 'Location: index.php' ); 
} else {
    include ('header.php');
    include ('imagechange.php');
    include ('loginform.php');
    }

include ('footer.php');
