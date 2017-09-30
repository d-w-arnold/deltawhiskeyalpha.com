<?php

require './vendor/autoload.php';

$name = $_POST['name'];
$email = $_POST['email'];
$messageText = $_POST['message'];

use SparkPost\SparkPost;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

$httpClient = new GuzzleAdapter(new GuzzleClient());
$sparky = new SparkPost($httpClient, ['key'=>'a6eb87028322ad4d6bbb01edd4922d71b2d9c132']);
$sparky->setOptions(['async' => false]);

try {
    $text = '';
    $text .= "Name: $name".PHP_EOL;
    $text .= "Email: $email".PHP_EOL;
    $text .= 'Message:'.PHP_EOL;
    $text .= '---'.PHP_EOL;
    $text .= $messageText;

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

    $message = 'Cool !';
    $status = 1;
} catch (\Exception $e) {
//    echo $e->getCode()."\n";
//    echo $e->getMessage()."\n";
//    die();

    $message = 'Some error happened, please fuck u';
    $status = 0;
}

$message = urlencode($message);
$status = urlencode($status);
header("Location: /contact.php?message=$message&status=$status");
