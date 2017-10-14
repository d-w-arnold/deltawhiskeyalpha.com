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
<script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.js" async defer></script>

<div style="text-align: left; margin-bottom: 4%">
    <p class="title" style="font-size: 20pt; margin-bottom: 3%"><u>Contact</u>:</p>
    <p>Please find the link to my ( ** CV ** ) at the top of the screen.</p>
    <br>
    <p>I am only a novice web developer, if you have any advice for ways in which I can improve this website, please send me an email. Thank you!</p>
    <br>
    <br>

    <?php
        $messages = @$_GET['messages'];
        if ($messages) {
            $messages = json_decode($messages);
        }
        $status = @$_GET['status'] || 0;
        $color = $status == 1 ? 'green' : 'red';

        if($messages && !empty($messages)) {
            foreach ($messages as $m) {
                echo "<p style='color: $color'>$m</p>";
            }
        }
    ?>

    <style>
        .contact-details {
            display: flex;
            flex-direction: row;
        }

        .contact-details .left {
            flex: 1;
        }

        .contact-details .right {
            flex: 1;
            margin-top: 5px;
        }
    </style>

    <div class="contact-details">
        <div class="left">
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
        <div class="right">
            <div class="LI-profile-badge"  data-version="v1" data-size="medium" data-locale="en_US" data-type="vertical" data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link" href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David W. Arnold</a></div>
        </div>
    </div>

</div>

<?php

include "./bottomHTML.php";
