<html>
    <?php 
        if (!isset($_GET["id"]) || preg_match('/^\d{1,10}$/', $_GET["id"]) === 0) {
            echo "ID is not correct." ;
            exit ;
        }
        session_start();
        if (!empty($_SESSION["userid"])):
    ?>
    <?php
        include_once 'components/header.php';
        require 'db.php';
        if(isset($_GET["id"])) {
            $serviceid = $_GET["id"];
            try {
                $sql = "select serviceid, title, description, image, price from services where serviceid=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$serviceid]);
                $service = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch(PDOException $ex) {
                echo "<p>", $ex->getMessage() ,"</p>" ;
            }
        }
        else {
            $service = null;
        }
    ?>
    <style>
    .buyBtn {
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
    .buyBtn:hover {
        cursor: pointer;
        background-color: rgb(65, 65, 65);
    }
    </style>
    <body class="grey darken-4"> 
        <?php 
            include_once 'components/login_navbar.php';
        ?>

        <div class="container white-text">
            <?php 
                if ($service && isset($service)):
            ?>
            <div class="row">
                <div class="col s12 center">
                    <h2>
                        <?=$service['title']?>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <img src="<?=$service['image']?>" style="max-width: 100%; max-height: 100%;">
                </div>
                <div class="col s6">
                    <div class="row">
                        <p>
                            <?=$service['description']?>
                        </p>
                    </div>  
                    <div class="row">
                        <h5>
                            $<?=$service['price']?>
                        </h5>
                    </div>
                    <div class="row">
                        <form action="cart.php" method="post">
                            <input type="text" class="datepicker white-text" placeholder="Select reservation date" name="selectedDate">
                            <input type="hidden" name="postedID" value="<?= $service["serviceid"] ?>">
                            <button class="waves-effect waves-dark buyBtn" name="buyBtn" type="submit">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col s12 center">
                    <h3>
                        No such service found.
                    </h3>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div style="margin-top: 100px;">
        </div>
        <?php
            include_once 'components/footer.php';
        ?>
        <script>
            $(function(){
                $(".datepicker").datepicker({
                    format : "yyyy-mm-dd",
                    onOpen : function() {
                        this.setDate(new Date(this.el.value));
                    }
                });
            });
        </script>
    </body>
    <?php 
        else: 
            header("Location: unauthorized.php");
        endif;
    ?>
</html>
