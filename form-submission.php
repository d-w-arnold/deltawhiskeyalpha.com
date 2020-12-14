<?php

require './vendor/autoload.php';
require 'reCAPTCHAsecret.php'; // Provides $reCAPTCHAsecret, add your own ReCAPTCHA API key.
require 'sparkpostSecret.php'; // Provides $sparkpostSecret, add your own Sparkpost API key.

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
            $text .= "Name: $name" . PHP_EOL;
            $text .= "Email: $email" . PHP_EOL;
            $text .= '---' . PHP_EOL;
            $text .= 'Message: ' . $message;
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
        } catch (Exception $e) {
            $status = 0;
        }

        if ($status == 1) {
            $sendStatus = "Message sent, I'll be in touch!";
        } else {
            $sendStatus = "Message not sent. Please try again at a later time.";
        }
    }
}

$color = ($status == 1) ? 'green' : 'orange';

if (!empty($sendStatus)) {
    echo "<p style='color:$color' class='statusMessage roboto'>" . $sendStatus . "</p><br>";
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
