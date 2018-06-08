<?php
// require functions and classes needed
require ('functions.php');

// start session
if ( is_session_started() === FALSE ) { 
    session_start();
}

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 

// redirect to login.php
header( 'Location: login.php' );

