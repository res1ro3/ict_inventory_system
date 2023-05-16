<?php 

    require("../dbConfig.php");

    $sql = "SELECT * FROM brand_tbl";
    $query = $conn->prepare($sql);
    $query->execute();
    
    $brands = [];
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $brands[] = $row['name'];
    }
    $json = json_encode($brands);
    echo $json;

?>