<html>
    <?php
        session_start();
        if (!empty($_SESSION["userid"])):
    ?>
    <?php
        include_once 'components/header.php';
        require 'db.php';
        try {
            $sql = "select serviceid, title, image, price from services";
            $stmt = $pdo->query($sql);
            $services = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
         } catch( PDOException $ex) {
             echo "<p>", $ex->getMessage() ,"</p>" ;
         }
    ?>
    <body class="grey darken-4 white-text">
        <?php 
            include_once 'components/login_navbar.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <h2>
                        Available Services
                    </h2>
                </div>
            </div>
            <?php 
                if(isset($services)):      
            ?>
            <div class="row">
                <?php foreach($services as $service): ?>
                    <div class="col s12 m4">
                        <div class="card grey darken-3">
                            <div class="card-image" style="max-width: 100%; max-height: 100%;">
                                <img src="<?=$service["image"]?>">
                                <a class="btn-floating halfway-fab waves-effect waves-light green" href="view_service.php?id=<?=$service["serviceid"]?>">
                                    <i class="material-icons">
                                        search
                                    </i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h6>$<?=$service["price"]?></h6>
                                <p><?=$service["title"]?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
            </div>
            
            <?php 
                else:
            ?>
            <div class="row">
                <div class="col s12 center">
                    <h3>
                        No services available.
                    </h3>
                </div>
            </div>
            <?php 
                endif;
            ?>
        </div>

        <?php
            include_once 'components/footer.php';
        ?>
    </body>
    <?php 
        else: 
            header("Location: unauthorized.php");
        endif;
    ?>
</html>
