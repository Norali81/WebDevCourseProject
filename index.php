<?php 
// include functions
require_once('functions.php');
require_once('classes.php');

if ( is_session_started() === FALSE ) { 
    session_start();
}
/*
 * This is the index.php file. It includes all other relevant files. 
 * Structure: 
 *      index.php 
 *          includes header.php 
 *                   doctor.php or pharmacist.php
 *                   newprescription.php or newdispensal.php, depending on role
 *                   footer.php
 */


// depending on role, require different files
if ($_SESSION['role']==='pha'){
    require_once('header.php');
    require_once('pharmacist.php');
    
} else if ($_SESSION['role']==='pat') {
    require_once('header.php');
    require_once('patient.php');
} else if ($_SESSION['role']==='doc') {
    require_once('header.php');
    require_once('doctor.php');
} else {
    // if no session active, load login.php
    header('Location: login.php');
}
?>

<?php include ('footer.php');?>