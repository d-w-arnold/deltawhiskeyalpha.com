<?php

$title = '';

include './topHTML.php';

?>

<div class="body">

    <p class="title">Welcome!</p>

    <div class="writing roboto">
        <p>Hello there, I’m a computer science graduate with a first class honours degree from the <a
                    class="link-color" target="_blank" href="https://www.kent.ac.uk/">University of Kent</a>. I’m eager
            to learn new skills and take on a role where I can contribute to solving real-world challenges. I am highly
            motivated, organised, reliable and work well both independently and as part of a team.</p>
    </div>

    <div class="spacing2"></div>

    <!--
    PeoplePerHour Profile Widget
    The div#pph-hire me is the element
    where the iframe will be inserted.
    You may move this element wherever
    you need to display the widget
-->
    <div id="pph-hireme"></div>
    <script type="text/javascript">
        (function (d, s) {
            var useSSL = 'https:' == document.location.protocol;
            var js, where = d.getElementsByTagName(s)[0],
                js = d.createElement(s);
            if (window.innerWidth > 600) {
                js.src = (useSSL ? 'https:' : 'http:') + '//www.peopleperhour.com/hire/2209121290/4399933.js?width=300&height=135&orientation=vertical&theme=dark&rnd=' + parseInt(Math.random() * 10000, 10);
            } else {
                js.src = (useSSL ? 'https:' : 'http:') + '//www.peopleperhour.com/hire/2209121290/4399933.js?width=240&height=135&orientation=vertical&theme=dark&rnd=' + parseInt(Math.random() * 10000, 10);
            }
            try {
                where.parentNode.insertBefore(js, where);
            } catch (e) {
                if (typeof console !== 'undefined' && console.log && e.stack) {
                    console.log(e.stack);
                }
            }
        }(document, 'script'));
    </script>

    <p class="title">Quantum Cryptography: Security for the Post-Quantum world</p>

    <div class="writing roboto">
        <p>As part of my final year of university, I undertook a research project
            titled <a
                    class="link-color"
                    target="_blank"
                    href="/research/Quantum_Cryptography-Security_for_the_Post-Quantum_world.pdf">"Quantum Cryptography:
                Security for the Post-Quantum world"</a>. This project set out to survey the field of quantum
            cryptography, providing a basic insight into various aspects of quantum cryptography - all of which could be
            very important regarding our online security in the future! Aimed at computer scientists and people in
            industry concerned with security.</p>
    </div>

    <div class="spacing4"></div>

    <p class="title">About Me</p>

    <div class="writing roboto">

        <p>Before I became a computer scientist, I was a golfer. Growing up my grandfather lived near a golf club and
            bought me my first set of golf clubs for my 7th birthday. By the age of 19, I had brought my golfing
            handicap down from 28 to -1. Over the years I represented <a class="link-color" target="_blank"
                                                                         href="https://www.kentgolf.org/">Kent County
                Golf Union</a> in various fixtures for their various teams: Kent Under 13's, Under 14's, Under 16's
            (Captain), Under 18's.</p>

        <div class="spacing2"></div>

        <p>In January 2016, I relinquished my amateur status and turned professional (aged 19) joining the <a
                    class="link-color" target="_blank" href="http://www.europrotour.com/">EuroPro UK Golf Tour</a> for
            the 2016 season. In August 2016, I hung up my golf clubs to turn my attention to undergraduate study in
            Computer Science at the <a class="link-color" target="_blank" href="https://www.kent.ac.uk/">University of
                Kent</a>. Golf remains a passion of mine, and will remain a lifetime hobby.</p>

        <div class="spacing2"></div>

        <p>Motorsport is a strong passion of mine. I have a broad knowledge of various disciplines of motor racing, and
            I enjoy learning of new technological developments to make cars faster, safer and more efficient at speed. I
            enjoy the thrill of driving on track, having invested in multiple track day sessions with tuition from
            professional racing drivers to better my skill set.</p>

        <div class="spacing2"></div>

        <p>Running used to be a big part of my regular training routine for golf. When I can I find it helps take things
            off ones mind and keep the body healthy. I participated in a half marathon in September 2016 and hope to do
            more half and full marathons in the future. I especially enjoy long runs along the coast.</p>
    </div>

</div>

<?php include './bottomHTML.php'; ?>
