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
    <p><a class="nav" style="padding: 0" target="_blank" href="https://www.linkedin.com/in/david-arnold-496b32147/">If you have Linkedin, click here for my profile.</a></p>
    <br>
    <p>I am only a novice website designer, if you have any advice for ways in which I can improve this website, please send me an email. Thank you!</p>
    <br>

    <?php
        $message = @$_GET['message'];
        $status = @$_GET['status'] || 0;
        $color = $status == 1 ? 'green' : 'red';

        if($message) {
            echo "<span style='color: $color'>$message</span>";
        }
    ?>

    <form id='contact-form' action="/contact_form.php" method="POST">
        <table id="contact-form-table">
            <tr>
                <td><label for="name">Name:</label></td>
                <td><input class="response" type="text" name="name" id="name"></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input class="response" type="text" name="email" id="email"></td>
            </tr>
            <tr class="row-textarea">
                <td><label for="message">Message:</label></td>
                <td><textarea class="response" name="message" id="message"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="g-recaptcha"
                            data-sitekey="6LdcpDIUAAAAAM9btQ69nAV7k8cYtLXHNUeb41UP"
                            data-callback='onSubmit'
                    >
                        Submit Email
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php

include "./bottomHTML.php";
