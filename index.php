<!DOCTYPE html>
<html>
    <head>
        <title>MarcoV4lente - Web Application Developer</title>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

        <nav class="white blue-grey-text text-darken-2">
            <div class="container">
                <div class="nav-wrapper">
                <a href="#" class="logo"><img src="images/marcov4lente-logo.png" alt="MarcoV4lente"></a>
                <ul id="nav-mobile" class="right hide-on-small-only">
                <li><a href="https://www.linkedin.com/in/marcov4lente/" class="red-text text-darken-4"><i class="fa fa-linkedin-square" aria-hidden="true"></i> Linked In</a></li>
                <li><a href="https://instagram.com/marcov4lente" class="red-text text-darken-4"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
                </ul>
                </div>
            </div>
        </nav>

        <!--div class="row hero" style="background-image: url('images/header-<?php print rand(1,4) ?>.jpg');"-->
        <div class="row hero">
            <div class="container">
                <div class="col s12 m3 avatar">
                    <img src="images/Marco-Valente-Avatar.jpg" alt="Marco V4lente Avatar">
                </div>
                <div class="col s12 m9 quote">
                    <h1>Hi, I'm Marco! I'm a web application developer!</h1>
                    <p>
                       Web technologies fascinate me, and I find pleasure in conceptualising and building functional web applications that serve purpose.
                    <p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="col s12 m6">
                    <p>
                        With eight years of practical commercial experience, I've had fantastic opportunities to work with companies and clients from across Europe and Africa. I have therefore had the great pleasure of developing web applications for a wide variety of purposes.
                    </p>
                </div>
                <div class="col s12 m6">
                    <p>
                        I strive to develop web solutions with a keen adherence to quality and standards. I am a firm believer of standards and best practices, which I feel is the cornerstone of a beautifully built application.
                    </p>
                </div>
            </div>
        </div>
        <footer class="page-footer white">
            <div class="copyright blue-grey-text text-darken-2 center-align">
                <p>
                    © <?php print date('Y') ?> Copyright MarcoV4lente, property of Marco Valente, all rights reserved.
                </p>
            </div>
        </footer>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
    </body>
</html>
