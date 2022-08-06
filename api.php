<?php
    // Very simple JSON API that returns the list of services
    header("Content-Type: application/json") ;
    header("Access-Control-Allow-Origin: *") ;
    $services = [];
    require 'db.php';
    try {
        $sql = "select serviceid, title, image, price from services";
        $stmt = $pdo->query($sql);
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
    } catch( PDOException $ex) {
        echo "<p>", $ex->getMessage() ,"</p>" ;
    }
    echo json_encode($services);
?>