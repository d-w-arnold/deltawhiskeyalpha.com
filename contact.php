<?php

$title = '∆WA : David W. Arnold - Contact';

include "./topHTML.php";

?>

<div id="contactBody">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.js" async defer></script>
    <script>
        function onSubmit(token) {
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
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    $status = 1;

    $statusMessages = [];

    $nameStatus = '';
    $emailStatus = '';
    $messageStatus = '';
    $securityStatus = '';
    $sendStatus = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = @$_POST['name'];

        if (empty($name)) {
            $status = 0;
            $nameStatus = "Please provide your name!";

        }

        $email = @$_POST['email'];

        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = 0;
            $emailStatus = "Please provide a valid email address!";
        } else if (empty($email)) {
            $status = 0;
            $emailStatus = "Please provide your email address!";
        }

        $message = @$_POST['message'];

        if (!$message || strlen($message) > 1000) {
            $status = 0;
            if (empty($message)) {
                $messageStatus = "Please type your message here!";
            } else {
                $messageStatus = "Your message is too long! 1000 characters max.";
            }
        }

        $gRecaptchaResponse = @$_POST['g-recaptcha-response'];

        $recaptcha = new ReCaptcha\ReCaptcha('6LdcpDIUAAAAABGjKLuEV8yb_PFp-OWSoxMWp4ch');

        $resp = $recaptcha->verify($gRecaptchaResponse, getRealIpAddr());

        if (!$resp->isSuccess()) {

            // $errors = $resp->getErrorCodes();
            // die(var_dump($errors));

            $securityStatus = "Please use the security provided, this is to prove you are not a robot.";
            $status = 0;
        }

        if ($status == 1) {
            $httpClient = new GuzzleAdapter(new GuzzleClient());
            $sparky = new SparkPost($httpClient, ['key'=>'a6eb87028322ad4d6bbb01edd4922d71b2d9c132']);
            $sparky->setOptions(['async' => false]);

            try {
                $text = '';
                $text .= "Name: $name".PHP_EOL;
                $text .= "Email: $email".PHP_EOL;
                $text .= '---'.PHP_EOL;
                $text .= 'Message: '.$message;

                $promise = $sparky->transmissions->post([
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
                                'name' => 'David Arnold',
                                'email' => 'david@deltawhiskeyalpha.com',
                            ],
                        ],
                    ],
                ]);
            } catch (\Exception $e) {
                $sendStatus = "This email cannot be submitted, please try at a later time.";
                $status = 0;
            }
        }

        if($status == 1) {
            $sendStatus = "Your message has been sent, thank you!";
        }

        if (!empty($nameStatus)) {
            $statusMessages["name"] = $nameStatus;
        }

        if (!empty($emailStatus)) {
            $statusMessages["email"] = $emailStatus;
        }

        if (!empty($messageStatus)) {
            $statusMessages["message"] = $messageStatus;
        }

        if (!empty($securityStatus)) {
            $statusMessages["security"] = $securityStatus;
        }

        if (!empty($sendStatus)) {
            $statusMessages["send"] = $sendStatus;
        }
    }

    $color = $status == 1 ? 'green' : 'red';

    if (@$statusMessages['security']) {
        echo "<p style='font-family:sans-serif;font-size:16px;color:$color'>".@$statusMessages['security']."</p>";
    }

    if (@$statusMessages['send']) {
        echo "<p style='font-family:sans-serif;font-size:16px;color:$color'>".@$statusMessages['send']."</p>";
    }

    ?>

    <div class="contact-details">
        <div class="left">
            <form id="contact-form" action="/contact.php" method="POST">
                <div class="tinySpacing"><label for="name">Name:</label></div>
                <input class="response" type="text" id="name" value="<?php if ($status == 1) {echo '';} else {echo $var = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';}?>" name="name" placeholder="<?php echo @$statusMessages['name'] ?>" onfocus="this.old_placeholder = this.placeholder; this.placeholder=''" onblur="this.placeholder = this.old_placeholder">
                <br>
                <div class="tinySpacing"><label for="email">Email Address:</label></div>
                <input class="response" type="text" id="email" value="<?php if ($status == 1) {echo '';} else {echo $var = isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST['email']) : '';}?>" name="email" placeholder="<?php echo @$statusMessages['email'] ?>" onfocus="this.old_placeholder = this.placeholder; this.placeholder=''" onblur="this.placeholder = this.old_placeholder">
                <br>
                <div class="tinySpacing"><label for="message">Message:</label></div>
                <textarea class="response" id="message" name="message" placeholder="<?php echo @$statusMessages['message'] ?>" onfocus="this.old_placeholder = this.placeholder; this.placeholder=''" onblur="this.placeholder = this.old_placeholder"><?php if ($status == 1) {echo '';} else if (strlen($_POST['message']) > 1000) {echo '';} else {echo $var = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';}?></textarea>
                <div class="tinySpacing">
                    <button id="button" class="g-recaptcha" data-sitekey="6LdcpDIUAAAAAM9btQ69nAV7k8cYtLXHNUeb41UP" data-callback='onSubmit'>Send Message</button>
                </div>
            </form>
        </div>
        <div class="right">
            <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US" data-type="vertical" data-theme="dark" data-vanity="david-w-arnold"><a class="LI-simple-link" href='https://uk.linkedin.com/in/david-w-arnold?trk=profile-badge'>David W. Arnold</a></div>
        </div>
    </div>

</div>

<?php

include "./bottomHTML.php";
