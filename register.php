<html>
    <?php
        require 'db.php';
        include_once 'components/header.php';
        require 'utils/regex_checker.php'; 
    ?>
    <?php
        
        if (isset($_POST["registerBtn"])) {
            $username = $_POST["username"];
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $error = [];
            if (!checkUsername($username) || !isset($username)) {
                $error["username"] = "Username is Invalid. Username cannot be shorter than 6 or longer than 20 characters.";
            }
            if (!checkFullname($fullname) || !isset($fullname)) {
                $error["fullname"] = "Name invalid. Name cannot be shorter than 5 characters or longer than 100 characters.";
            }
            if (!checkEmail($email) || !isset($email)) {
                $error["email"] = "Email is invalid" ;
            }
            if (!checkPassword($password) || !isset($password)) {
                $error["password"] = "Password must include at least one lowercase letter, one uppercase letter and one number.";
            }          
            if (count($error) == 0) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
                $stmt->execute([$email]); 
                $user = $stmt->fetch();
                if ($user) {
                    $error["emailExists"] = "There already exists a user associated with this email";
                } 
                else {
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
                    $stmt->execute([$username]); 
                    $user = $stmt->fetch();
                    if ($user) {
                        $error["usernameExists"] = "There already exists a user associated with this username";
                    } 
                    else {
                        $options = [
                            'cost' => 11
                        ];
                        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $options);
                        $password = "";
                        $sql = "INSERT INTO users (username, email, password, fullname) VALUES (?, ?, ?, ?)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$username, $email, $passwordHash, $fullname]);
                        header("Location: login.php");
                    }  
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
        <?php 
            include_once 'components/navbar.php';
        ?>

        <!-- Registration form beginning -->
        <div class="container">
            <div class="row">
                <div class="col s12 center font-roboto-black">
                    <h2>
                        <span class="white-text">REGISTER</span> 
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="col s6">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="input-field col s10">
                                        <input placeholder="Enter your full name here" id="fullname" type="text" class="validate" name="fullname">
                                        <label for="fullname">Full Name</label>
                                    </div>
                                    <div class="col s2">
                                        <?php
                                            if (isset($error) && key_exists("fullname", $error)) {
                                                echo '<span class="material-icons red-text" style="margin-top: 1em;">cancel</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s10">
                                        <input placeholder="Enter your username here" id="username" type="text" class="validate" name="username">
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="col s2">
                                        <?php
                                            if (isset($error) && key_exists("username", $error)) {
                                                echo '<span class="material-icons red-text" style="margin-top: 1em;">cancel</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s10">
                                        <input id="email" type="email" class="validate" name="email" placeholder="Enter your email here">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col s2">
                                        <?php
                                            if (isset($error) && key_exists("email", $error)) {
                                                echo '<span class="material-icons red-text" style="margin-top: 1em;">cancel</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s10">
                                        <input id="password" type="password" class="validate" name="password" placeholder="Enter your password here">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="col s2">
                                        <?php
                                            if (isset($error) && key_exists("password", $error)) {
                                                echo '<span class="material-icons red-text" style="margin-top: 1em;">cancel</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s10">
                                        <button class="waves-effect waves-dark regButton" href="register.php" name="registerBtn" type="submit">Register</button>
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
                        <div class="col s6">
                            <img src="static/images/faker.jpg" alt="" style="max-width: 100%; max-height: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include_once 'components/footer.php';
        ?>
    </body>
</html>