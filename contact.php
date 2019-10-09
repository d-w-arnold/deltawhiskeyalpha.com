<?php

$title = ' - Contact';

include "./topHTML.php";

?>

<div class="body">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.js" async defer></script>
    <script>
        $(function () {
            $.validator.setDefaults({
                errorClass: 'error'
            });

            $("#contact-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        maxlength: 1000
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name.",
                        minlength: "At least 2 characters please."
                    },
                    email: {
                        required: "Please enter a valid email address."
                    },
                    message: "Please enter no more than 1000 characters."
                }
            });
        });

        function onSubmit() {
            document.getElementById("contact-form").submit();
        }
    </script>

    <p class="title" id="contactTitle">Contact</p>

    <?php

    require './vendor/autoload.php';

    use GuzzleHttp\Client as GuzzleClient;
    use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
    use SparkPost\SparkPost;

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    $status = 1;
    $sendStatus = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = @$_POST['name'];
        $email = @$_POST['email'];
        $message = @$_POST['message'];

        if (empty($name) || empty($email) || empty($message)) {
            $sendStatus = "Please give your: Name, Email Address, and write your Message before clicking 'Send Your Message'. Thank you.";
            $status = 0;
        }

        if (strlen($message) > 1000) {
            $sendStatus = "Please enter no more than 1000 characters as the message. Thank you.";
            $status = 0;
        }

        require 'reCAPTCHAsecret.php';
        require 'sparkpostSecret.php';

        $gRecaptchaResponse = @$_POST['g-recaptcha-response'];
        $recaptcha = new ReCaptcha\ReCaptcha($reCAPTCHAsecret);
        $resp = $recaptcha->verify($gRecaptchaResponse, getRealIpAddr());
        if (!$resp->isSuccess()) {
            $status = 0;
        }

        if ($status == 1) {
            $httpClient = new GuzzleAdapter(new GuzzleClient());
            $sparky = new SparkPost($httpClient, ['key' => ($sparkpostSecret), 'async' => false]);
            try {
                $text = '';
                $text .= "Name: $name".PHP_EOL;
                $text .= "Email: $email".PHP_EOL;
                $text .= '---'.PHP_EOL;
                $text .= 'Message: '.$message;
                $transmissionData = [
                    'content' => [
                        'from' => [
                            'name' => 'DWA',
                            'email' => 'website@deltawhiskeyalpha.com',
                        ],
                        'reply_to' => $email,
                        'subject' => "Website",
                        'text' => $text,
                    ],
                    'recipients' => [
                        [
                            'address' => [
                                'name' => 'David W. Arnold',
                                'email' => 'david@deltawhiskeyalpha.com',
                            ],
                        ],
                    ],
                ];
                $promise = $sparky->transmissions->post($transmissionData);
            } catch (\Exception $e) {
                $sendStatus = "Message not sent. Please try again at a later time.";
                $status = 0;
            }
            $sendStatus = "Message sent, I'll be in touch!";
        }
    }

    $color = ($status == 1) ? 'green' : 'red';

    if (!empty($sendStatus)) {
        echo "<p style='color:$color' class='statusMessage roboto'>".$sendStatus."</p><br>";
    }

    function name($status)
    {
        if ($status == 1) {
            echo '';
        } else {
            echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        }
    }

    function email($status)
    {
        if ($status == 1) {
            echo '';
        } else {
            echo isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars(
                $_POST['email']
            ) : '';
        }
    }

    function textArea($status)
    {
        if ($status == 1) {
            echo '';
        } else {
            if (strlen($_POST['message']) > 1000) {
                echo '';
            } else {
                echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
            }
        }
    }

    header('Location:/contact.php#contactTitle');

    ?>

    <div class="roboto">
        <div class="contact-details">
            <div class="left">
                <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US"
                     data-type="vertical"
                     data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link"
                                                                       href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David
                        W. Arnold</a></div>
                <div class="center github"
                "><a href="https://github.com/d-w-arnold" target="_blank"><img src="/resources/github.png" alt="Github"
                                                                               width="64" height="64"></a></div>
        </div>
        <div class="right">
            <form id="contact-form" action="/contact.php" method="POST">
                <div class="tinySpacing">
                    <label for="name">Name:</label>
                </div>
                <input class="response" type="text" id="name" name="name" tabindex="1" value="<?php name($status) ?>"
                       autofocus>
                <div class="tinySpacing">
                    <label for="email">Email Address:</label>
                </div>
                <input class="response" type="email" id="email" name="email" tabindex="2"
                       value="<?php email($status) ?>">
                <div class="tinySpacing">
                    <label for="message">Message:</label>
                </div>
                <textarea class="response" id="message" name="message" tabindex="3" rows="10"><?php textArea(
                        $status
                    ) ?></textarea>
                <div class="tinySpacing center">
                    <button id="button" tabindex="4" class="g-recaptcha"
                            data-sitekey="6Lcl1rcUAAAAAP9cwFpK09YM8xi3Lhbc0jjgSFWs" data-callback="onSubmit">Send Your
                        Message
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include "./bottomHTML.php"; ?>
