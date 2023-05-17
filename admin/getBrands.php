<?php 

    require("../dbConfig.php");

    function getRepairs($type, $brand) {
        if ($type == 'Hardware') {
            require('../dbConfig.php');
            $sql = "SELECT * FROM ict_network_hardware_tbl WHERE brand = :br";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'br' => $brand
            ));
    
            $res = $query->rowCount();
            return $res;
        }
    }

    $sql = "SELECT * FROM brand_tbl";
    $query = $conn->prepare($sql);
    $query->execute();
    $brandCount = $query->rowCount();
    
    $brands = [];
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $brands[] = $row['name'];
    }

    $repairs = [];

    for ($i = 0; $i < $brandCount; $i++) {
        $row = getRepairs("Hardware", $brands[$i]);
        $repairs[] = $row;
    }
    
    $json = json_encode([$brands, $repairs]);
    echo $json;

?>