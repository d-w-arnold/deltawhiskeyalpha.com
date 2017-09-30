<?php

$title = '∆WA : David W. Arnold - Contact';

include "./topHTML.php";

?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onSubmit(token) {
        document.getElementById("contact-form").submit();
    }
</script>

<div style="text-align: left; margin-bottom: 4%">
    <p style="font-size: 20pt; margin-bottom: 3%"><u>Contact</u>:</p>
    <p>** If you haven't already, please find the link to my CV at the top of the screen **</p>
    <br>
    <p>LinkedIn*:&nbsp;&nbsp;&nbsp;&nbsp;<a class="nav" style="padding: 0" href="https://www.linkedin.com/in/david-arnold-496b32147/">https://www.linkedin.com/in/david-arnold-496b32147/</a></p>
    <br>
    <p>I am only a novice website designer, if you have any advice for ways in which I can improve this website, please send me an email. Thank you!</p>
    <br>
    <p style="font-size: 11pt">(*For security reasons, my profile is not made public and is only available to LinkedIn members.)</p>

    <?php
        $message = @$_GET['message'];
        $status = @$_GET['status'] || 0;
        $color = $status == 1 ? 'green' : 'red';

        if($message) {
            echo "<span style='color: $color'>$message</span>";
        }
    ?>

    <form id='contact-form' action="/contact_form.php" method="POST">
        <input type="text" name="name">
        <input type="text" name="email">
        <textarea name="message"></textarea>
        <button class="g-recaptcha"
                data-sitekey="6LdcpDIUAAAAAM9btQ69nAV7k8cYtLXHNUeb41UP"
                data-callback='onSubmit'
        >
            Submit
        </button>
    </form>
</div>

<?php

include "./bottomHTML.php";
