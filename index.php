<html>
    <?php
        include_once 'components/header.php';
    ?>
    <style>
        .cRegisterButton {
            border: 2px solid #2196f3;
            border-radius: 30px;
            margin: 20px auto;
            line-height: 40px;
            text-align: center;
            padding: 10px 0px 10px 0px;
            color: white;
            display: block;
            margin-top: 50px;
            width: 250px;
            font-size: 1.4em;
        }

        .cRegisterButton:hover {
            cursor: pointer;
            background-color: #2196f3;  
        }
    </style>
    <body class="grey darken-4 white-text">
        <?php
        session_start(); 
        if (!isset($_SESSION['userid'])) {
            include_once 'components/navbar.php';
        }
        else {
            include_once 'components/login_navbar.php';
        }
        ?>

        <div class="parallax-container" style="margin-top: 1em;">
            <div class="parallax">
                <img src="static/images/index_adlike.jpg" alt="">
            </div>
        </div>
        <div class="section grey darken-4 white-text">
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <h2>
                        ARE YOU READY TO LEARN FROM 
                    </h2>
                    <h1>
                        <span class="red-text lighten-2">THE BEST?</span> 
                    </h1>
                </div>
            </div>
        </div>
        <div class="parallax-container">
            <div class="parallax">
                <img src="static/images/coach2.jpg" alt="" style="width:50%">           
            </div>
        </div>
        <div class="section grey darken-4 white-text">
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <h2>
                        UP YOUR GAME BY MEETING THE <span class="yellow-text">PROS</span> OF E-SPORTS
                    </h2>
                </div>
            </div>
            <div class="row" style="margin-top: 70px;">
                <div class="col s12 center font-roboto-black">
                    <h5>
                        Register now to book a private coaching session.
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <a href="register.php" class="waves-effect waves-light cRegisterButton" style="margin-top: 100px;">Register</a>
                </div>
            </div>
        </div>
        <div style="height: 100px;"></div>
        <script>
            $(document).ready(function(){
                $('.parallax').parallax();
            });
        </script>
        <?php
            include_once 'components/footer.php';
        ?>
    </body>
</html>
