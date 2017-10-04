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

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$gRecaptchaResponse = $_POST['g-recaptcha-response'];

$errorMessages = [];
$status = 1;

foreach (['name', 'email', 'message'] as $field) {
    if(empty(${$field})) {
        $errorMessages[] = "Please provide your $field.";
        $status = 0;
    }
}

if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "Please provide a valid email address so I may contact you.";
    $status = 0;
}

$recaptcha = new ReCaptcha\ReCaptcha('6LdcpDIUAAAAABGjKLuEV8yb_PFp-OWSoxMWp4ch');
$resp = $recaptcha->verify($gRecaptchaResponse, getRealIpAddr());
if (!$resp->isSuccess()) {
    // $errors = $resp->getErrorCodes();
    // die(var_dump($errors));

    $errorMessages[] = "Please use the security provided to prove you are not a robot.";
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
        $text .= 'Message:'.PHP_EOL;
        $text .= '---'.PHP_EOL;
        $text .= $message;

        $promise = $sparky->transmissions->post([
            'content' => [
                'from' => [
                    'name' => 'DWA',
                    'email' => 'website@deltawhiskeyalpha.com',
                ],
                'reply_to' => $email,
                'subject' => "DWA - Email from $name",
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
//        echo $e->getCode()."\n";
//        echo $e->getMessage()."\n";
//        die();

        $errorMessages[] = "This email cannot be submitted, please try at a later time.";
        $status = 0;
    }
}

if($status == 1) {
    $errorMessages = ["Thank you for submitting your email!"];
}

$errorMessages = urlencode(json_encode($errorMessages));
$status = urlencode($status);
header("Location: /contact.php?messages=$errorMessages&status=$status");
