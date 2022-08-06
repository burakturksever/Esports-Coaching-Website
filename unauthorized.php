<html>
    <style>
        .cLoginButton {
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

        .cLoginButton:hover {
            cursor: pointer;
            background-color: #2196f3;  
        }
    </style>
    <?php
        include_once 'components/header.php';
    ?>
    <body class="grey darken-4 white-text">
        <?php 
            include_once 'components/navbar.php';
        ?>
        <div class="container">
            <div class="row" style="margin-top: 100px;">
                <div class="col s12 center">
                    <h3>
                        You are not authorized to view this page. 
                    </h3>
                    <h4>
                        Please login first.
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <a href="login.php" class="waves-effect waves-light cLoginButton" style="margin-top: 100px;">Login</a>
                </div>
            </div>
        </div>
        <div style="height: 300px;"></div>
        <?php
            include_once 'components/footer.php';
        ?>
    </body>
</html>