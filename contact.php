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
        $(function() {
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

    <p class="title">Contact</p>

    <?php

    require './vendor/autoload.php';

    use SparkPost\SparkPost;
    use GuzzleHttp\Client as GuzzleClient;
    use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    $status = 1;
    $statusMessages = [];
    $sendStatus = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = @$_POST['name'];
        $email = @$_POST['email'];
        $message = @$_POST['message'];

        $gRecaptchaResponse = @$_POST['g-recaptcha-response'];
        $recaptcha = new ReCaptcha\ReCaptcha('6LdcpDIUAAAAABGjKLuEV8yb_PFp-OWSoxMWp4ch');
        $resp = $recaptcha->verify($gRecaptchaResponse, getRealIpAddr());
        if (!$resp->isSuccess()) {
            $status = 0;
        }

        if ($status == 1) {
            $httpClient = new GuzzleAdapter(new GuzzleClient());
            $sparky = new SparkPost($httpClient, ['key'=>'a6eb87028322ad4d6bbb01edd4922d71b2d9c132', 'async' => false]);
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
                $sendStatus = "Message cannot be submitted, please try again at a later time.";
                $status = 0;
            }
        }
        if($status == 1) {
            $sendStatus = "Your message has been sent!";
        }
    }

    $color = ($status == 1) ? 'green' : 'red';

    if (!empty($sendStatus)) {
        echo "<p style='color:$color' class='statusMessage'>".$sendStatus."</p>";
    }

    function name($status) {
        if ($status == 1) {
            echo '';
        } else {
            echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        }
    }

    function email($status) {
        if ($status == 1) {
            echo '';
        } else {
            echo isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST['email']) : '';
        }
    }

    function textArea($status) {
        if ($status == 1) {
            echo '';
        } else if (strlen($_POST['message']) > 1000) {
            echo '';
        } else {
            echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
        }
    }

    ?>

    <div class="contact-details">
        <div class="left">
            <form id="contact-form" action="/contact.php" method="POST">
                <div class="tinySpacing"><label for="name">Name:</label></div>
                <input class="response" type="text" id="name" name="name" value="<?php name($status)?>">
                <br>
                <div class="tinySpacing"><label for="email">Email Address:</label></div>
                <input class="response" type="email" id="email" name="email" value="<?php email($status)?>">
                <br>
                <div class="tinySpacing"><label for="message">Message:</label></div>
                <textarea class="response" id="message" name="message"><?php textArea($status)?></textarea>
                <div class="tinySpacing">
                    <button id="button" class="g-recaptcha" data-sitekey="6LdcpDIUAAAAAM9btQ69nAV7k8cYtLXHNUeb41UP" data-callback="onSubmit">Send</button>
                </div>
            </form>
        </div>
        <div class="right">
            <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US" data-type="vertical" data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link" href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David W. Arnold</a></div>
        </div>
    </div>

</div>

<?php include "./bottomHTML.php"; ?>
