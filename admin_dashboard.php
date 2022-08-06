<html>
    <?php
        require 'db.php';
        session_start();
        if (!empty($_SESSION["adminid"])):
    ?>
    <?php
        include_once 'components/header.php';

        if (isset($_POST["deleteID"])) {
            $idToDelete = $_POST["deleteID"];
            $sql = "DELETE FROM users WHERE userid = ?";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([$idToDelete]);
                echo "<script>M.toast({html: 'User Deleted Successfully', classes: 'rounded tst'});</script>";
            }
            catch (PDOException $ex) {
                echo "<script>M.toast({html: 'Database Error', classes: 'rounded tst'});</script>";
            }
        }
        if (isset($_POST["serviceDeleteID"])) {
            $serviceToDelete = $_POST["serviceDeleteID"];
            $sql = "DELETE FROM services WHERE serviceid = ?";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([$serviceToDelete]);
                echo "<script>M.toast({html: 'Service Deleted Successfully', classes: 'rounded tst'});</script>";
            }
            catch (PDOException $ex) {
                echo "<script>M.toast({html: 'Database Error', classes: 'rounded tst'});</script>";
            }
        }
        if (isset($_POST["orderToDelete"])) {
            $userid = $_POST["orderToDelete"]["userid"];
            $serviceid = $_POST["orderToDelete"]["serviceid"];
            $sql = "DELETE FROM users_services WHERE userid = ? AND serviceid = ?";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([$userid, $serviceid]);
                echo "<script>M.toast({html: 'Order Deleted Successfully', classes: 'rounded tst'});</script>";
            }
            catch (PDOException $ex) {
                echo "<script>M.toast({html: 'Database Error', classes: 'rounded tst'});</script>";
            }
        }
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
        table {
            border-collapse: collapse !important;
        }
        td, th{
            border: 1px solid gray !important; 
        }
        .deleteClass:hover, .deleteService:hover, .deleteOrder:hover {
            cursor: pointer;
        }
        table.highlight>tbody>tr:hover {
            background-color: rgba(77, 77, 77, 0.2);;      /* whatever color you want */
        }
        thead:hover {
            cursor: pointer;
        }
    </style>
    <body class="grey darken-4 white-text">
        <?php 
            include_once 'components/login_navbar.php';
            try {
                $sql = "select userid, fullname, username, email from users";
                $stmt = $pdo->query($sql) ;
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
             } catch( PDOException $ex) {
                 echo "<p>", $ex->getMessage() ,"</p>" ;
             }
             try {
                $sql = "select serviceid, title, description, image, price from services";
                $stmt = $pdo->query($sql) ;
                $services = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
             } catch( PDOException $ex) {
                 echo "<p>", $ex->getMessage() ,"</p>" ;
             }
             try {
                $sql = "select us.userid, us.serviceid, us.delivery_date, s.title, u.username from users_services us, services s, users u where us.userid = u.userid and us.serviceid = s.serviceid";
                $stmt = $pdo->query($sql) ;
                $users_services = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
             } catch( PDOException $ex) {
                 echo "<p>", $ex->getMessage() ,"</p>" ;
             }
        ?>
        
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <div class="row" style="margin-top: 2em;">
                        <h4>
                            User List
                        </h4>
                    </div>
                    <div class="row">
                        <table class="highlight responsive-table centered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Ops</th>
                                </tr>
                            </thead>
                            <?php if(isset($users)): ?>
                            <tbody>
                                <?php foreach ($users as $user):?>
                                <tr>
                                    <td><?=$user["userid"]?></td>
                                    <td><?=$user["fullname"]?></td>
                                    <td><?=$user["username"]?></td>
                                    <td><?=$user["email"]?></td>
                                    <td>
                                        <span class="material-icons deleteClass" value="<?=$user["userid"]?>">
                                            delete_forever
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach;
                                else:?>
                                    <tr>
                                        <td colspan="5">No Users Found</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <div class="row" style="margin-top: 2em;">
                        <h4>
                            Services
                        </h4>
                        <a href="add_service.php" class="grey-text text-lighten-1">
                            <div class="right valign-wrapper">
                                Add new service
                                <span class="material-icons" style="margin-left: 10px;">
                                    add
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                        <table class="highlight responsive-table centered" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Service Title</th>
                                    <th>Service Description</th>
                                    <th>Price</th>
                                    <th>Ops</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($services)): ?>
                                <?php foreach ($services as $service):?>
                                <tr>
                                    <td><?=$service["serviceid"]?></td>
                                    <td><img src="<?=$service["image"]?>" alt="<?=$service["title"]?>" style="width: 100px; height: 100px;"></td>
                                    <td><?=$service["title"]?></td>
                                    <td><?=$service["description"]?></td>
                                    <td><?=$service["price"]?></td>
                                    <td>
                                        <span class="material-icons deleteService" value="<?=$service["serviceid"]?>">
                                            delete_forever
                                        </span>
                                        <a class="white-text" href="edit_service.php?editID=<?=$service["serviceid"]?>">
                                            <span class="material-icons editClass">
                                                edit
                                            </span>
                                        </a>    
                                    </td>
                                </tr>
                                <?php endforeach; 
                                else:?>
                                    <tr>
                                        <td colspan="5">No Services Found</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <div class="row" style="margin-top: 2em;">
                        <h4>
                            User Orders
                        </h4>
                    </div>
                    <div class="row">
                        <table class="highlight responsive-table centered" id="usersOrdersTable">
                            <thead>
                                <tr>
                                    <th>Service Title</th>
                                    <th>Username</th>
                                    <th>Delivery Date</th>
                                    <th>Ops</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($users_services)): ?>
                                <?php foreach ($users_services as $users_service):?>
                                <tr>
                                    <td><?=$users_service["title"]?></td>
                                    <td><?=$users_service["username"]?></td>
                                    <td><?=$users_service["delivery_date"]?></td>
                                    <td>
                                        <span class="material-icons deleteOrder" data-servid="<?=$users_service["serviceid"]?>" data-usid="<?=$users_service["userid"]?>">
                                            delete_forever
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; 
                                    else:?>
                                    <tr>
                                        <td colspan="5">No Orders Found</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function () {
            $("#usersTable").DataTable({
                "searching": false,
                "paging": false
            });
            $("#servicesTable").DataTable({
                "searching": false,
                "paging": false
            });
            $("#usersOrdersTable").DataTable({
                "searching": false,
                "paging": false
            });
        });
        $(".deleteClass").click(function () {
            var idToDelete = $(this).attr("value");
            $.ajax({
                method: "POST",
                url: "admin_dashboard.php",
                beforeSend: function() {
                    M.toast({html: 'Deleting user with ID: ' + idToDelete, classes: 'rounded tst'});    
                },
                data: {"deleteID": idToDelete} 
            })
            .done(function (data) {
                var table = $(data).find("#usersTable").html();
                $('#usersTable').html(table);
            });
        });
        $(".deleteService").click(function () {
            var serviceToDelete = $(this).attr("value");
            $.ajax({
                method: "POST",
                url: "admin_dashboard.php",
                beforeSend: function() {
                    M.toast({html: 'Deleting service with ID: ' + serviceToDelete, classes: 'rounded tst'});    
                },
                data: {"serviceDeleteID": serviceToDelete} 
            })
            .done(function (data) {
                var table = $(data).find("#servicesTable").html();
                $('#servicesTable').html(table);
            });
        });
        $(".deleteOrder").click(function () {
            var userid = $(this).data("usid");
            var serviceid = $(this).data("servid");
            $.ajax({
                method: "POST",
                url: "admin_dashboard.php",
                beforeSend: function() {
                    M.toast({html: 'Deleting order with UserID: ' + userid + " and ServiceID: " + serviceid, classes: 'rounded tst'});    
                },
                data: {"orderToDelete": {
                    "userid": userid,
                    "serviceid": serviceid   
                }} 
            })
            .done(function (data) {
                var table = $(data).find("#usersOrdersTable").html();
                $('#usersOrdersTable').html(table);
            });
        });
    </script>
    </body>
    <?php 
        else: 
            header("Location: unauthorized_adm.php");
        endif;
    ?>
</html>
