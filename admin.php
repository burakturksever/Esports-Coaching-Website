<html>
    <?php
        require 'db.php';
        include_once 'components/header.php';
        require 'utils/regex_checker.php'; 
    ?>
    <?php
        
        if (isset($_POST["loginBtn"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $options = [
                'cost' => 11
            ];
            $error = [];
            if (!checkUsername($username) || !isset($username)) {
                $error["username"] = "Username is Invalid. Username cannot be shorter than 6 or longer than 20 characters.";
            }
            if (!checkPassword($password) || !isset($password)) {
                $error["password"] = "Password must include at least one lowercase letter, one uppercase letter and one number.";
            }
            if (count($error) == 0) {
                $stmt = $pdo->prepare("SELECT adminid, username, password  FROM admins WHERE username=?");
                $stmt->execute([$username]); 
                $user = $stmt->fetch();
                if ($user) {
                    if(password_verify($password, $user["password"])) {
                        $password = "";
                        session_start();
                        $_SESSION["adminid"] = $user["adminid"];
                        $_SESSION["username"] = $user["username"];
                        header("Location: admin_dashboard.php");
                    }
                    else {
                        $error["passwordIncorrect"] = "The password you have entered is incorrect.";
                    }
                }
                else {
                    $error["userDoesNotExist"] = "This user does not exist.";
                }
            }
        }
    ?>
    <style>
    /* label focus color */
    .input-field :focus + label {
        color: #ffffff !important;
    }
    /* label underline focus color */
    .input-field :focus {
        border-bottom: 1px solid #ffffff !important;
        box-shadow: 0 1px 0 0 #ffffff !important;
    }
    .input-field input[type="text"] {
        color: #ffffff !important;
    }
    .input-field input[type="password"] {
        color: #ffffff !important;
    }
    .input-field input[type="email"] {
        color: #ffffff !important;
    }
    .regButton {
        background-color: rgb(87, 87, 87);
        border: 1px solid black;
        border-radius: 30px;
        margin: 20px auto;
        line-height: 40px;
        text-align: center;
        padding: 10px 0px;
        color: white;
        display: block;
        margin-top: 50px;
        width: 250px;
        font-size: 1.4em;
        transition: 0.3s;
    }
    .regButton:hover {
        cursor: pointer;
        background-color: rgb(65, 65, 65);
    }
    </style>
    <body class="grey darken-4 white-text">
        <!-- Admin login form beginning -->
        <div class="container">
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <h2>
                        <span class="white-text">ADMINISTRATOR LOGIN</span> 
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="row" style="margin-top: 3em;">
                        <div class="col s3"></div>
                        <div class="col s6 center">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input placeholder="Enter your username here" id="username" type="text" class="validate" name="username">
                                        <label for="username">Username</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="password" type="password" class="validate" name="password" placeholder="Enter your password here">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <button class="waves-effect waves-dark regButton" href="login.php" name="loginBtn" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                                if (!empty($error)) {
                                    echo "<script>" ;
                                    foreach($error as $e) {
                                        $e= "<span style=\"font-weight:bold\">$e</span>";
                                        echo "M.toast({html: '$e',classes: 'rounded tst'}); ";
                                    }
                                    echo "</script>" ;
                                }
                            ?>
                        </div>
                        <div class="col s3"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>