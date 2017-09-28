<?php

$title = '∆WA : David W. Arnold - Contact';

include "./topHTML.php";

?>

<div style="text-align: left; margin-bottom: 4%">
    <p style="font-size: 20pt; margin-bottom: 3%"><u>Contact</u>:</p>
    <p>** If you haven't already, please find the link to my CV at the top of the screen **</p>
    <br>
    <p>LinkedIn*:&nbsp;&nbsp;&nbsp;&nbsp;<a class="nav" style="padding: 0" href="https://www.linkedin.com/in/david-arnold-496b32147/">https://www.linkedin.com/in/david-arnold-496b32147/</a></p>
    <br>
    <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;<a class="nav" style="padding: 0" id="e" href="#"></a></p>
    <br>
    <p>I am only a novice website designer, if you have any advice for ways in which I can improve this website, please send me an email. Thank you!</p>
    <br>
    <p style="font-size: 11pt">(*For security reasons, my profile is not made public and is only available to LinkedIn members.)</p>
</div>

<script>
    function base64Decode(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    }

    var emailb64 = 'ZGF2aWRAZGVsdGF3aGlza2V5YWxwaGEuY29t';

    var em = document.getElementById('e');
    var email = base64Decode(emailb64);
    em.textContent = email;
    em.href = 'mailto:'+email+'?subject=Hello%20David!';
</script>

<?php

include "./bottomHTML.php";
