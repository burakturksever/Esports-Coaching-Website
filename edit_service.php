<html>
    <?php
        if (!isset($_GET["editID"]) || preg_match('/^\d{1,10}$/', $_GET["editID"]) === 0) {
            echo "ID is not correct." ;
            exit ;
        }
        session_start();
        if (!empty($_SESSION["adminid"])):
            
    ?>
    <?php
        include_once 'components/header.php';
        $games = [
            "League of Legends"=> "static/images/lol.jpg",
            "Fortnite"=> "static/images/fortnite.jpg",
            "Overwatch"=> "static/images/overwatch.jpg",
            "Dota 2"=> "static/images/dota2.jpg",
            "CS:GO"=> "static/images/csgo.jpg",
            "Hearthstone"=> "static/images/hearthstone.jpg",
            "World of Warcraft"=> "static/images/wow.jpg",
            "Counter Strike"=> "static/images/cs.jpg",
            "Valorant"=> "static/images/valorant.jpg"
        ];
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
    .input-field textarea {
        color: #ffffff !important;
    }
    .addServiceBtn {
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
    .addServiceBtn:hover {
        cursor: pointer;
        background-color: rgb(65, 65, 65);
    }
    ul.dropdown-content.select-dropdown li span {
        background-color: #212121;
        color: #fff;
    }
    ul.dropdown-content.select-dropdown li span:hover {
        background-color: #424242;
        color: #fff;
    }
    </style>
    
    <body class="grey darken-4 white-text">
        <?php 
            include_once 'components/login_navbar.php';
            include 'utils/regex_checker.php';
            require 'db.php';
            if (isset($_GET["editID"])) {
                $editID = $_GET["editID"];
                $sql = "SELECT * FROM services WHERE serviceid = $editID";
                try {
                    $result = $pdo->query($sql);
                    $service = $result->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Database Error: " . $e->getMessage();
                    exit;
                }
            }
            else {
                $service = null;
            }
            if (isset($_POST["addServiceBtn"])) {
                $title = $_POST["title"];
                $description = $_POST["description"];
                $price = $_POST["price"];
                if(!isset($_POST["game_selection"])) {
                    $image = "-1";
                }
                else {
                    $image = $_POST["game_selection"];
                }
                $postedID = $_POST["postedID"];
                var_dump($postedID);
                $error = [];
                if (!checkServiceTitle($title) || !isset($title)) {
                    $error["title"] = "The title should be at least 5 and at most 100 characters. It may only include letters, numbers and spaces.";
                }
                if (!checkServiceDescription($description) || !isset($description)) {
                    $error["description"] = "The description should be at least 10 and at most 1000 characters. It may only include letters, numbers, spaces and [.,-_+].";
                }
                if (!checkServicePrice($price) || !isset($price)) {
                    $error["price"] = "The price should be at least 1 digit and at most 6 digits. It may only include whole numbers.";
                }
                if (!isset($image) || $image == "-1" || !checkServiceImage($image)) {
                    $error["image"] = "Invalid selection. Please select a game.";
                }
                if (count($error) == 0) {
                    $sql = "UPDATE services SET title=?, description=?, image=?, price=? WHERE serviceid=?";
                    $stmt = $pdo->prepare($sql);
                    try {
                        $stmt->execute([$title, $description, $image, $price, $postedID]);
                        header("Location: admin_dashboard.php");
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            }
        ?>
        <div class="container">
        <?php if($service && isset($service)): ?>
            <div class="row center" style="margin-top: 3em;">
                <h4>
                    Edit Service
                </h4>
                <form action="" method="post" style="margin-top: 3em;">
                <div class="row">
                    <div class="input-field col s4">
                            <select name="game_selection">
                                <option value="-1" disabled selected>Choose the game</option>
                                <?php
                                    foreach ($games as $key => $value) {
                                        if ($value == $service["image"]) {
                                            echo "<option value='$value' selected>$key</option>";
                                        }
                                        else {
                                            echo "<option value='$value'>$key</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label>Game Selection</label>
                    </div>
                    <div class="input-field col s4">
                        <input placeholder="Enter the new service title here" id="title" type="text" name="title" value="<?=$service["title"]?>">
                        <label for="title">Service Title</label>
                    </div>
                    <div class="input-field col s4">
                        <input placeholder="Enter the service price here" id="price" type="text" name="price" value="<?=$service["price"]?>">
                        <label for="price">Service Price</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="description" class="materialize-textarea" name="description" placeholder="Enter description for the service here">
                        </textarea>
                        <label for="description">Service Description</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="waves-effect waves-dark addServiceBtn" href="edit_service.php" name="addServiceBtn" type="submit">Update Service</button>
                    </div>
                </div>
                <input type="hidden" name="postedID" value="<?= $service["serviceid"] ?>">
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
                <?php else: ?>
                    <div class="row center">
                        <h4>
                            No such service found.
                        </h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('select').formSelect();
                $("#description").val("<?=$service["description"]?>");
                M.textareaAutoResize($('#description'));
            });
        </script>
    </body>
    <?php 
        else: 
            header("Location: unauthorized_adm.php");
        endif;
    ?>
</html>
