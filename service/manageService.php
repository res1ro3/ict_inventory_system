<?php
    require_once('../dbconfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        
    } else {
        header("Location: ../admin/signin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service</title>
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
        <div class="servicelist">
            <div class="dashboard-header" style="margin: 2rem 0">
                <h3>Manange Service</h3>
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
                    <th>Employee Owner</th>
                    <th>Processed By</th>
                </thead>
                <tbody>
                    <?php
                        $sql="SELECT * FROM services_tbl WHERE type_of_ict = 'Equipment'";
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
                        <td><?= $row['employee_id'] ?></td>
                        <td><?= $row['processed_by'] ?></td>
                    </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#service_tbl').DataTable();
        });
    </script>
</html>