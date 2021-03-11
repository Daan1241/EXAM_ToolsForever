<?php
$sanitized = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
require "pdo.php";

if($sanitized['action'] == "delete_selected"){
    $deletelist = [];
    $deletelist_raw = json_decode($_POST['deletelist']);
    print_r($deletelist_raw);

    foreach($deletelist_raw as $item){
        $location = explode("_", $item)[0];
        $productID = explode("_", $item)[1];

        $sql = "SELECT locationID FROM locations WHERE locationname=?";
        $run = $connection->prepare($sql);
        $run->execute([$location]);
        $result = $run->fetchAll();
        $locationID = $result[0]['locationID'];

        echo "Deleting from ".$location." with ID ".$locationID. " and productID ".$productID."\n";

        echo "DELETE FROM locations_has_products WHERE ID='".$productID."' AND locations_locationID='".$locationID."'";
        $sql = "DELETE FROM locations_has_products WHERE ID=? AND locations_locationID=?";
        $run = $connection->prepare($sql);
        $run->execute([$productID, $locationID]);
        $rowcount_productcopies = $run->fetchAll();
    }
//    print_r($deletelist);


} else {
    echo "no action";
}


?>