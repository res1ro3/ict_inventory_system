<?php 

    require("../dbConfig.php");

    function getRepairs($type) {
        if ($type == 'Hardware') {
            require('../dbConfig.php');
            $sql = "SELECT ict_network_hardware_tbl.brand
                    FROM services_tbl
                    JOIN ict_network_hardware_tbl
                    ON ict_network_hardware_tbl.hardware_id = services_tbl.ICT_ID";
            $query = $conn->prepare($sql);
            $query->execute();
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
    }

    function countRepairs($type) {
        if ($type == 'Hardware') {
            require('../dbConfig.php');
            $sql = "SELECT ict_network_hardware_tbl.brand
                    FROM services_tbl
                    JOIN ict_network_hardware_tbl
                    ON ict_network_hardware_tbl.hardware_id = services_tbl.ICT_ID";
            $query = $conn->prepare($sql);
            $query->execute();
            $refcount = $query->rowCount();
            return $refcount;
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
    $repairs = getRepairs("Hardware");
    
    $refcount = [];
    $refcount = countRepairs("Hardware");

    $repair_counts = [];

    for ($i = 0; $i < $brandCount; $i++) {
        $ctr = 0;
        foreach ($repairs as $repair) {
            if ($repair['brand'] == $brands[$i]) {
                $ctr++;
            }
        }
        $repair_counts[$i] = $ctr;
    }

    $json = json_encode([$brands, $repair_counts]);
    echo $json;

?>