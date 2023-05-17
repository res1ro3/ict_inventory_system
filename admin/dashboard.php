<?php 
    require_once('../dbConfig.php');
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $user = $_SESSION['username'];
    } else {
        header("Location: signin.php");
    }

    function getRepairs($type, $brand) {
        if ($type == 'Hardware') {
            require('../dbConfig.php');
            $sql = "SELECT * FROM ict_network_hardware_tbl WHERE brand = :br";
            $query = $conn->prepare($sql);
            $query->execute(array(
                'br' => $brand
            ));
    
            $res = $query->rowCount();
    
            echo $res;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user ?></title>
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>
    <div class="dashboard">
    <div id="sidebar-placeholder"><?php include("../sidebar.php") ?></div>
        <div class="container-fluid m-5">
            <div class="row d-flex flex-column">
                <div class="col data-header"><h3>As of Today <?= '('.date("m/d/Y").')'?></h3></div>
                <div class="col d-flex flex-row">
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>0</p></div>
                        <div class="col-8 data-text">
                            <p>ICT Equipments to be replace</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <?php 
                            $sql = "SELECT * FROM services_tbl WHERE service_status = 'Pending'";
                            $query = $conn->query($sql);
                            $query -> execute();
                            $pendingCount=$query->rowCount();
                        ?>
                        <div class="col-4 data-digit"><p><?= $pendingCount ?></p></div>
                        <div class="col-8 data-text">
                            <p>Pending technical support</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <?php 
                            $sql = "SELECT * FROM services_tbl WHERE service_status = 'On Going'";
                            $query = $conn->query($sql);
                            $query -> execute();
                            $ongoingCount=$query->rowCount();
                        ?>
                        <div class="col-4 data-digit"><p><?= $ongoingCount ?></p></div>
                        <div class="col-8 data-text">
                            <p>Ongoing technical support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex flex-column">
                <div class="col data-header"><h3>Brand VS Repair</h3></div>
                <div class="col-8">
                    <canvas id="brands_chart"></canvas>
                </div>
            </div>
            
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        $(document).ready(function() {
            var brands_repair = [];
            $.ajax({
                    url: 'getBrands.php',
                    method: 'GET',
                }).then((res) => {
                    brands_repair = JSON.parse(res);
                    var ctx = document.getElementById("brands_chart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: brands_repair[0],
                            datasets: [{
                                label: 'Brand VS Repair',
                                data: brands_repair[1],
                                backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    min: 0,
                                    max: 10,
                                    ticks: {
                                        stepsize: 1
                                    }
                                }
                            }
                        }
                    });
                });

            
        })
        
        
    </script>
</body>
</html>