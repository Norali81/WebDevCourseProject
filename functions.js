/*function loadPrescriptionForDispensal {
    
}*/

// function that is called after the patientsearch function. This loads the table with prescriptions
function loadPrescriptions(pID, role) {
                   //var response;
                   
                   // making ajax request to retrieve prescriptions
                    $.ajax({
                        type:"POST",
                        url:"backend/getPrescriptions.php",
                        data: ({patientID: pID, role:role}),
                        cache: false, 
                        success: function(data) {
                            // empty prescription <div> and put in table with prescriptions
                            $('#prescriptions').empty();
                            $('#prescriptions').append(data);
                            $("#newPrescription").empty();
                            $("#dispensePrescription").empty();
                            // log result to console for information
                            console.log(data);
                        }
                    })
                     .fail(function() {
                         return aler+-t('Something went wrong. Can\'t load prescription history');
                     })
                     .complete(function(response, textStatus) {
                       // return alert("Loadprescription: " + textStatus);
                     })  
                ;
                     
            };
             
// function that is called when the button "New Prescription" is clicked.
function newPrescription(pID) {
    
    // get prescription ID from the selected radiobutton
    var prescriptionID = $('input[name=prescription]:checked').val();
    
    // make an ajax request to get the prescription html form
    $.ajax({
            url: 'newprescription.php',
            data: ({prescriptionID: prescriptionID}),
            success: function(data) {
            // insert the html code for the form into the <div> newprescription
            $('#newPrescription').html(data);
            // insert the patient ID in the hidden field patientID
            $( "#patientID" ).val(pID);
            }
    });
} 

// function that is called when the button "Dispense" is clicked. 
// this loads a html form to input the dispensal information
function dispensePrescription(pID) {
    // get prescription ID from the selected radiobutton
    var prescriptionID = $('input[name=prescription]:checked').val();
    // if a radiobutton is selected
    if (prescriptionID>0) {
            $.ajax({
                    
                    // make ajax request and get content for <div> dispensePrescription
                    data: {patientID:pID, presID:prescriptionID},
                    url: 'dispenseprescription.php',
                    success: function(data) {
                    $('#dispensePrescription').html(data);
                    // fill hidden input field with patient ID
                    $('#patientID').val(pID);
                    $('#prescriptionID').val(prescriptionID);
                }
            });
    } else {
            alert("Please select a medication to dispense");
    }  
}

//function to search for a patient ID
function searchPatient(pID, role) {
    
    if (validateInt(pID)==true) {
                // initialze variable 'response'
                var response;
                // this variable is needed in the loadPrescirptions function
                // otherwise everything blows up
                patientID=pID;
                
            // make ajax request to retrieve patient details from backend
            $.ajax({
                type:"POST",
                url:"backend/getPatient.php",
                data: ({patientID: pID}),
                cache: false, 
                success: function(data) {
                    console.log(response);
                    response=JSON.parse(data);
                    // handle different cases of response
                    if (data==0) {
                        alert('No patient found'); 
                    } else if (data==-1) {
                        alert('Duplicate patient, call an administrator');
                    } else {
                        // populate patient details in <div> pDetails
                        $('#pDetails').html('<h3>Patient Details: </h3>Patient name: '+ 
                                response.firstname + ' ' + 
                                response.lastname + '<br> Date of Birth: ' + 
                                response.dob);
                        // call function to load table with prescirptions
                        loadPrescriptions(pID, role);
                    }
                }
            })
             /*.done(function(data) {
                // todo
             });*/
    } else {
        alert('Please enter a whole number');
    }
}     
        
            
// tooltip
$(function() {
    $( document ).tooltip({
        position: {
                    my: "center bottom-20",
                    at: "center top"
                  }
        });
  });
  
   // function to validate if an input is an int
   // returns 1 if int 
    function validateInt(number) {
            var regexNumber = new RegExp(/^\d+$/);
            return regexNumber.test(number);
        }
              
