<?php

/*
 * Function to verify username and password. Returns true if username and password are found in database
 * Otherwise returns false
 */
function verifyUser($username, $password, $dbConnect) {
            $debug=0;
                        // escaping username
                        $usernameE = $dbConnect->real_escape_string($username);
                        // constructing query
			$sql = "SELECT password FROM user WHERE username='$usernameE'";
                            // debug statement
                            if ($debug===1) {echo $sql."<br>"."Username: ".$usernameE."<br>";}
              
                        // making query to database
			$result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");

                        // if there is more than 1 row of results, we have a duplicate username
			if (($result->num_rows)>1) {
				echo "<br>Duplicate user with username '".$username."'";
                                return false;
                        // if there is no result, we don't have this username
			} else if  (($result->num_rows)==0) {
				echo "<br>No user found wich this username<br>"; 
				return false;
                        // 
			} else {
                                // get the result row
				$row = $result->fetch_object();
                                // check if the password in the db is equal to the  
                                // hashed value of the password the user entered
				if (($row->password) == $password) {
                                                return true;
				} else {
                                                return false;
				}
			$result->free();		
			}
				
}

function getUserRole($dbConnect, $username) {
    $sql="SELECT role FROM user WHERE username='".$username."'";
    $result = $dbConnect->query($sql) Or 
                die ("<p>Unable to execute the query.</p>". 
                 "<p>Error code ".($dbConnect->error)."</p>");
    // if there is more than 1 row of results, we have a duplicate username
    if (($result->num_rows)>1) {
	echo "<br>Duplicate user with username '".$username."'";
        return false;
        // if there is no result, we don't have this username
    } else if  (($result->num_rows)==0) {
        echo "<br>No user found wich this username<br>"; 
	return false;
    } else {
        // get the result row
	$row = $result->fetch_object();
        // check if the password in the db is equal to the  
        // hashed value of the password the user entered
        $result->free();
        return $row->role;
    }

}

function getUserID($dbConnect, $username) {
    $sql="SELECT userID FROM user WHERE username='".$username."'";
    $result = $dbConnect->query($sql) Or 
                die ("<p>Unable to execute the query.</p>". 
                 "<p>Error code ".($dbConnect->error)."</p>");
    // if there is more than 1 row of results, we have a duplicate username
    if (($result->num_rows)>1) {
	echo "<br>Duplicate user with username '".$username."'";
        return false;
        // if there is no result, we don't have this username
    } else if  (($result->num_rows)==0) {
        echo "<br>No user found wich this username<br>"; 
	return false;
    } else {
        // get the result row
	$row = $result->fetch_object();
        // check if the password in the db is equal to the  
        // hashed value of the password the user entered
        $result->free();
        return $row->userID;
    }

}

/*
 * Reusable function to execute database query with only one table and one "where" condition
 * The function uses the database connection, the tablename, field to query and the condition as input and returns one row
 * In the end we didn't re-use this function, because it is too restricted. 
 */
function getDataByComperator($dbConnect, $table, $field, $comperator) {
    
    // sql query
    $sql = "SELECT * FROM ".$table." WHERE ".$field."='".$comperator."'";
    
    // execute query
    $result = $dbConnect->query($sql) Or 
                                die ("<p>Unable to execute the query.</p>". 
                                "<p>Error code ".($dbConnect->error)."</p>");
    
    // fetch row
    $row = $result->fetch_object();
    // return row
    $result->free();	
    return $row;
}

/*
 * Function to connect to the database. 
 */
function connectDatabase() {
	// switching on for debugging. Switch off in production
	error_reporting(E_ALL);
        
        // creating connection 
        // 
	$dbConnect = new mysqli("<host>","<username>","<password>", "<DB-name>") ;
        
	// comment this in for detailed error number
	//echo ($dbConnect -> connect_error);

	// test if connection was successful
	if ($dbConnect -> connect_errno) {
		die ("Can't connect to database. Please contact us");
	}
        // return connection
	return $dbConnect;
}

/*
 * This function finds when a prescription was last dispensed
 */
function getLastDispensed ($prescriptionID, $dbConnect) {
    
    // connect to database
    $dbConnect = connectDatabase();
    
    // query
    $sql="SELECT MAX(date) FROM dispensal WHERE prescriptionID=$prescriptionID";
    // execute query
    $result = $dbConnect -> query($sql) Or die ($dbConnect->error);
    // fetch array as a result
    $row = $result -> fetch_array();
    // If no result, return "--", else return the date
    if ($row[0]==null) {
        return "--";
    } else {
        return date('d.m.y', strtotime($row[0])); 
    }
       
}

// function to check the session status
// taken from php manual 
//http://php.net/manual/en/function.session-status.php
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}
