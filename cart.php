<html>
<?php 
    session_start();
    if (!empty($_SESSION["userid"])):
?>
<?php
    if (isset($_POST['buyBtn'])) {
        if (!isset($_SESSION["cart_items"])) {
            $_SESSION["cart_items"] = array();
        }
        if (!empty($_POST["selectedDate"])){
            $temp = array(
                "postedID" => $_POST["postedID"],
                "selectedDate" => $_POST["selectedDate"]
            );
            if (!in_array($temp, $_SESSION["cart_items"])) {
                array_push($_SESSION["cart_items"], $temp);
            }
            else {
                $error = [];
                $error["alreadyInCart"] = "This service is already in your cart.";
            }
        }
        else {
            $error = [];
            $error["noDateSelected"] = "You have not selected a date for the service. Not adding to cart.";
        }
        
    }
    $services = [];
    require 'db.php';
?>
<?php 
    if (isset($_POST["emptyCart"])) {
        unset($_SESSION["cart_items"]);
    }
    if (isset($_POST["checkout"])) {
        $cart_items = $_SESSION["cart_items"];
        $userid = $_SESSION["userid"];
        foreach ($cart_items as $item) {
            $serviceid = $item["postedID"];
            $selectedDate = $item["selectedDate"];
            try {
                $sql = "insert into users_services (userid, serviceid, delivery_date) values (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$userid, $serviceid, $selectedDate]);
            } catch (PDOException $ex) {
                echo "<p>", $ex->getMessage() ,"</p>" ;
            }
            unset($_SESSION["cart_items"]);
        }
    }
?>
<?php
    include_once 'components/header.php';
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
    <body class="grey darken-4 white-text">
        <?php 
            include_once 'components/login_navbar.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <div class="row" style="margin-top: 2em;">
                        <h4>
                            Cart
                        </h4>
                    </div>
                    <div class="row">
                        <table class="highlight responsive-table centered" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Service Title</th>
                                    <th>Selected Date</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION["cart_items"]) && !empty($_SESSION["cart_items"])): ?>
                                <?php 
                                    $total = 0;
                                    foreach ($_SESSION["cart_items"] as $item):
                                ?>
                                <?php 
                                    $sql = "SELECT * FROM services WHERE serviceid=?";
                                    $stmt = $pdo->prepare($sql);
                                    try {
                                        $stmt->execute([$item['postedID']]);
                                        $service = $stmt->fetch();
                                    } catch (PDOException $e) {
                                        echo "Error: " . $e->getMessage();
                                    }    
                                ?>
                                <tr>
                                    <td><img src="<?=$service["image"]?>" alt="<?=$service["title"]?>" style="width: 100px; height: 100px;"></td>
                                    <td><?=$service["title"]?></td>
                                    <td><?=$item['selectedDate']?></td>
                                    <td>$<?=$service["price"]?></td>
                                    <?php $total += $service['price']; ?>
                                </tr>
                                <?php endforeach; 
                                else:?>
                                    <tr>
                                        <td colspan="5"><h4>The cart is empty</h4></td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                        <?php if (!empty($_SESSION["cart_items"])) :?>
                        <div class="row" style="margin-top: 3em;">
                            <div class="col s12 right-align">
                                <h5 id="total">Total: $<?=$total?></h5>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col s12 center">
                                <div class="col s4">
                                    <button class="waves-effect waves-dark buyBtn" id="empty">Empty Cart</button>
                                </div>
                                <div class="col s4">
                                    <a class="waves-effect waves-dark buyBtn" href="shop.php">Back to Shop</a>
                                </div>
                                <div class="col s4">
                                    <button class="waves-effect waves-dark buyBtn" id="checkout">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        <?php
            include_once 'components/footer.php';
        ?>
        <script>
            $(document).ready(function () {
                $("#servicesTable").DataTable({
                    "searching": false,
                    "paging": false
                });
            });
            $("#empty").click(function () {
                $.ajax({
                    method: "POST",
                    url: "cart.php",
                    beforeSend: function() {
                        M.toast({html: 'Emptied cart.', classes: 'rounded tst'});    
                    },
                    data: {"emptyCart": "true"} 
                })
                .done(function (data) {
                    var table = $(data).find("#servicesTable").html();
                    $('#servicesTable').html(table);
                    $('#total').html("");
                });
            });
            $("#checkout").click(function () {
                $.ajax({
                    method: "POST",
                    url: "cart.php",
                    beforeSend: function() {
                        M.toast({html: 'Checked out cart.', classes: 'rounded tst'});    
                    },
                    data: {"checkout": "true"} 
                })
                .done(function (data) {
                    var table = $(data).find("#servicesTable").html();
                    $('#servicesTable').html(table);
                    $('#total').html("");
                    M.toast({html: 'You have been billed $<?=$total?>', classes: 'rounded tst'});
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