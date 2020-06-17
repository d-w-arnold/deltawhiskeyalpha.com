<?php

$title = ' - Contact';

include "./topHTMLnoIndex.php";

?>

<div class="body">

    <script type="text/javascript">
        function onSubmit() {
            document.getElementById("contact-form").submit();
        }
    </script>
    <script type="text/javascript" src="form-validate.js"></script>
    <?php require 'form-submission.php'; ?>

    <p id="contactTitle" class="title">Contact</p>

    <div class="roboto">
        <div class="contact-details">
            <div class="left">
                <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US"
                     data-type="vertical"
                     data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link"
                                                                       href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David
                        W. Arnold</a></div>
                <div id="github" class="center logos"><a href="https://github.com/d-w-arnold" target="_blank"><img
                                src="/resources/github_white.png"
                                alt="GitHub"
                                width="64" height="64"></a></div>
                <div id="keybase" class="center logos"><a href="https://keybase.io/d_w_arnold" target="_blank"><img
                                src="/resources/keybase-tile.svg"
                                alt="Keybase"
                                width="64" height="64"></a></div>
            </div>
            <div class="right">
                <form id="contact-form" action="<?php header('Location:/contact.php#contactTitle'); ?>" method="POST">
                    <div class="tinySpacing">
                        <label for="name">Name:</label>
                    </div>
                    <input class="response" type="text" id="name" name="name" tabindex="1"
                           value="<?php name($status) ?>"
                           autofocus>
                    <div class="tinySpacing">
                        <label for="email">Email Address:</label>
                    </div>
                    <input class="response" type="email" id="email" name="email" tabindex="2"
                           value="<?php email($status) ?>">
                    <div class="tinySpacing">
                        <label for="message">Message:</label>
                    </div>
                    <textarea class="response" id="message" name="message" tabindex="3"
                              rows="6"><?php textArea($status) ?></textarea>
                    <div class="buttonPlacement">
                        <button id="button" tabindex="4" class="g-recaptcha"
                                data-sitekey="6Lcl1rcUAAAAAP9cwFpK09YM8xi3Lhbc0jjgSFWs" data-callback="onSubmit">Send
                            Your Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include "./bottomHTML.php"; ?>
