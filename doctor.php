   <!-- After login, the index.php will require this file if the user is a doctor -->

    <script type="text/javascript">
    // get session variables and initialise variable patient id
            var patientID="";
            var userID="<?php echo $_SESSION["userID"];?>";
            var role = "<?php echo $_SESSION["role"];?>"
           
  
   function changeButton() {
        document.getElementById("newButton").innerHTML="renew prescription";
    }

    </script>
        
        <!-- Display form for patients search-->
        <p>
        Enter a patient's account number: 
        <form name="psearch">
        <img src="./images/help.jpg" alt="help" class="tooltip" title="Because patients have chip cards, search is by account number. Try entering 1, 4, 5 or 6">
        <input type="text" name="psearchInput">  
        
        <!-- on submit, execute function searchPatient(patientID, role)  --> 
        <button type="button" name="patientsearch" onclick="searchPatient(document.psearch.psearchInput.value, 'doc')">Search</button>
        </form>
      
        <!-- paragraph to store patient details --> 
        <p class='pDetails' id='pDetails'></p>

        <!-- div container to load prescription table --> 
        <p class= 'prescritpions' id='prescriptions'></p>

        <!-- div container to populate html form for writing a new prescription --> 
        <div class='newPrescription' id='newPrescription'>
        
        </div>