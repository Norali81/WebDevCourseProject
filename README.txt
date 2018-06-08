******* Prescribex Readme ********

*** Installation *** 

Database: 
Log into mySQL and execute the files in the folder "database" in the following order: 
1. create_db_script.sql
2. inserts.sql
3. drugs.sql
4. generics.sql

You may have to open the file create_db_script.sql and replace the database name
'prescribex' with the desired name of the database. 

The script drugs.sql disables foreign key checks because there are a few corrupt
entries in our data source but we couldn't figure out which. So some medications
might be without a matching generic, but in our testing we never found this to be the case.  

The foreign key checks are enabled again after running the script generics.sql

*** Login *** 

You can login with the following users:
 
Doctor (prescribe medicaitons)
username: doctor password: hello  

Pharmacist (dispense medications)
username: pharmacist password: hello

*** Workflow ***
Log in as doctor, search for patients 1,4,5 or 6 and prescribe them some medications.

Then log in as pharmacist and dispense the medications to the patient.

*** Database login ***
If you need to change the database login, this can be done in the file
functions.php. The function is called connectDatabase().

This line has to be commented in
$dbConnect = new mysqli("<host>","<username>","<password>", "<db_name>") ;

*** Contact us form ***
The contact us form sends an email to the email specified in the form and to info@prescribex.com
Emails to info@prescribex.com can be seen as follows: 
CPanel
Email Accounts
Little Arrow next to info@prescribex.com
Access Webmail
"Read Mail Using Roundcube"

*** Sources *** 
We have taken code from the following sources: 
Code to autocomplete fields with units, drug names etc 
https://jqueryui.com/autocomplete/

Code for the contact form: 
http://stackoverflow.com/questions/18379238/send-email-with-php-from-html-form-on-submit-with-the-same-script

Code for Image Slide fucntion: 
http://www.sitepoint.com/web-foundations/making-simple-image-slider-html-css-jquery/

Use tutorial for Pricing Plan Table: 
http://webdesign.tutsplus.com/articles/build-a-modern-pricing-table-with-html-and-css--webdesign-4130



 


