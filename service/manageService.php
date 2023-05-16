<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $_SESSION['accType'] == "Super Admin" ? $showType = "Admin" : $showType = "Ordinary User" ;
    } else {
        header("Location: ../admin/signin.php");
    }

    function getEmployee($ictid, $type) {
        require('../dbConfig.php');

        if ($type == 'Hardware') {
            $sql = "SELECT * FROM ict_network_hardware_tbl WHERE mac_address = :ictid";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'ictid' => $ictid
            ));
    
            $res = $query->fetch(PDO::FETCH_ASSOC);
    
            return $res['owner_name'];
        } 
        else if ($type == 'Software') {
            $sql = "SELECT * FROM software_tbl WHERE software_id = :ictid";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'ictid' => $ictid
            ));
    
            $res = $query->fetch(PDO::FETCH_ASSOC);
    
            return $res['owner_name'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management of Accounts</title>
    <link rel="stylesheet" href="../styles/jquery.dataTables.min.css" />
    <script src="../js/jquery-3.5.1.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="service.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="service">
        <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="service-container">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Manange Services</h3>
            </div>
            <table id="service_tbl">
                <thead>
                    <th>#</th>
                    <th>Type of Service</th>
                    <th>Type of ICT</th>
                    <th>ICT ID</th>
                    <th>Date Received</th>
                    <th>Date Returned</th>
                    <th>Description of Service</th>
                    <th>Action Done</th>
                    <th>Recommendation</th>
                    <th>Owner Name</th>
                    <th>Processed By</th>
                </thead>
                <tbody>
                    <?php
                        $sql="SELECT * FROM services_tbl";
                        $query = $conn->prepare($sql);
                        $query->execute();
                        $result = $query->fetchAll();
                        $count = 1;
                        foreach ($result as $row) {
                            
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $row['type_of_services'] ?></td>
                        <td><?= $row['type_of_ict'] ?></td>
                        <td><?= $row['ICT_ID'] ?></td>
                        <td><?= $row['date_received'] ?></td>
                        <td><?= $row['date_returned'] ?></td>
                        <td><?= $row['description_of_service'] ?></td>
                        <td><?= $row['action_done'] ?></td>
                        <td><?= $row['recommendation'] ?></td>
                        <td><?= getEmployee($row['ICT_ID'], $row['type_of_ict']) ?></td>
                        <td><?= $row['processed_by'] ?></td>
                    </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#service_tbl').DataTable();
        });
    </script>
</html>