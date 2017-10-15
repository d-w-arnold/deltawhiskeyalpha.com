<?php

$title = '∆WA : David W. Arnold - Contact';

include "./topHTML.php";

?>

    <style>
        .contactFormat {
            width: 70%;
            margin: 0 auto;
        }
    </style>

    <div class="contactFormat" style="text-align: left; margin-bottom: 6%">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onSubmit(token) {
                document.getElementById("contact-form").submit();
            }
        </script>
        <script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.js" async defer></script>
        <p class="title" style="margin-bottom: 6%">Contact</p>
        <p><a class="cv" style="padding: 0" target="_blank" href="./resources/DWA_resume_cv.pdf?1">Click here for my CV
                (Résumé).</a></p>
        <br>
        <p>If you have any advice for ways in which I can improve this website, please send me an email. Thank you!</p>
        <br>

        <?php
        $messages = @$_GET['messages'];
        if ($messages) {
            $messages = json_decode($messages);
        }
        $status = @$_GET['status'] || 0;
        $color = $status == 1 ? 'green' : 'red';

        if ($messages && !empty($messages)) {
            foreach ($messages as $m) {
                echo "<p style='color: $color'>$m</p>";
            }
        }
        ?>

        <br>
        <div class="contact-details">
            <div class="left">
                <form id='contact-form' action="/contact_form.php" method="POST">
                    <div>
                        <label for="name">Your Name:</label>
                    </div>
                    <div>
                        <input class="response" type="text" name="name" id="name">
                    </div>
                    <br>
                    <div>
                        <label for="email">Your Email:</label>
                    </div>
                    <div>
                        <input class="response" type="text" name="email" id="email">
                    </div>
                    <br>
                    <div style="margin: 0 0 2% 0">
                        <label for="message">Message:</label>
                    </div>
                    <div>
                        <textarea class="response" name="message" id="message"></textarea>
                    </div>
                    <button class="g-recaptcha"
                            data-sitekey="6LdcpDIUAAAAAM9btQ69nAV7k8cYtLXHNUeb41UP"
                            data-callback='onSubmit'
                    >
                        Send Email
                    </button>
                </form>
            </div>
            <div class="right">
                <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US"
                     data-type="vertical" data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link"
                                                                                            href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David
                        W. Arnold</a></div>
            </div>
        </div>

    </div>

<?php

include "./bottomHTML.php";
