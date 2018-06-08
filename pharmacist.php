
     <script type="text/javascript">
            var patientID="";
            var userID="<?php echo $_SESSION["userID"];?>";
            var role = "<?php echo $_SESSION["role"];?>"

    </script>

        <p>
        Enter a patient's account number: 
        <form name="psearch">
        <img src="./images/help.jpg" alt="help" class="tooltip" title="Because patients have chip cards, search is by account number. Try entering 1, 4, 5 or 6">
        <input type="text" name="psearchInput"> 
        <button type="button" name="patientsearch" onclick="searchPatient(document.psearch.psearchInput.value, 'pha')">Search</button>
        </form>
        <p class='pDetails' id='pDetails'></p>
        
        <p class= 'prescritpions' id='prescriptions'></p>


        <div class='dispensePrescription' id='dispensePrescription'>

        </div>