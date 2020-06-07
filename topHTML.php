<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#282828">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="./resources/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./style.css">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#282828">
    <meta name="description"
          content="Home of Computer Scientist and University of Kent undergraduate, David W. Arnold.">
    <title><?php echo 'David W. Arnold : ∆WA' . $title ?></title>
</head>
<body onload="myFunction()">
<?php $cv_path = '/resources/David_W_Arnold-CV-website.pdf' ?>
<div id="loader">
    <div id="loading">
        <img id="loading-icon" src="./favicon/android-chrome-192x192.png" alt="Loading ...">
    </div>
</div>
<div id="myDiv" class="animate-bottom">
    <header>
        <div id="top">
            <div class="alignRight">
                <a class="iconLink" target="_blank" href="https://github.com/d-w-arnold">
                    <i class="fa fa-github-square" aria-hidden="true"></i>
                </a>
                <a class="iconLink" target="_blank" href="https://www.linkedin.com/in/david-w-arnold">
                    <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                </a>
                <a class="iconLink" target="_blank" href="https://keybase.io/d_w_arnold">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </a>
                <a id="cv" target="_blank" href="<?php echo $cv_path ?>">** CV (Résumé) **</a>
            </div>
            <div class="alignLeft">
                <p id="delta">
                    <a href="/">∆WA</a>
                </p>
            </div>
        </div>
        <div>
            <h1 id="myName"><a class="link-color" target="_blank" href="<?php echo $cv_path ?>">David W. Arnold</a></h1>
        </div>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="./education.php">Education</a></li>
                <li><a href="./computing.php">Computing</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
