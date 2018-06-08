
<?php include ('header.php');?>

<?php include ('imagechange.php');?>

<div id ="cont">
<div id ="content">

<h1><i>CONTACT US</i></h1>
<hr>

<p class ="center">
We are here to help and we will contact you as soon as possible.Please note, we cannot help with any medical queries via the form.
All medical queries are handled by our secure messaging platform, available only after your online consultation is completed.
</p>

<script type="text/javascript">
    
    function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    var result = re.test(email);
    return result;
}
</script>


 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="mailform" method="POST" onsubmit="return validateEmail(document.mailform.email.value)">
    <input name="action" value="submit" type="hidden">
    <input name="name" size="30" type="text" placeholder="Your Name"><br>
    <input name="email" size="30" type="text" placeholder="Your Email"><br>
    <textarea name="message" rows="7" cols="28" placeholder="Non Medical Query"></textarea><br>
    <input value="Send email" name="submit" type="submit">
    </form>
</div>
</div>

<?php

/*
 * Code from http://stackoverflow.com/questions/18379238/send-email-with-php-from-html-form-on-submit-with-the-same-script
 */
if(isset($_POST['submit'])){
   

    $name=$_POST['name'];
    $to = "info@prescribex.dxhost.net"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['name'];
    $subject = "Prescribex client query";
    $subject2 = "Copy of your query to the Prescribex team";
    $message = $name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    echo "Your query has been sent. Thank you " . $name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    // You cannot use header and echo together. It's one or the other.
    }


?>



<?php include ('footer.php');?>



