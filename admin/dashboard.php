<?php 
    session_start();
    if (isset($_SESSION) && $_SESSION['status'] == 'valid') {
        $user = $_SESSION['username'];
    } else {
        header("Location: signin.php");
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
        <?php include("../sidebar.php") ?>
        <div class="container-fluid m-5">
            <div class="row d-flex flex-column">
                <div class="col data-header"><h3>As of Today <?= '('.date("m/d/Y").')'?></h3></div>
                <div class="col d-flex flex-row">
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>3</p></div>
                        <div class="col-8 data-text">
                            <p>ICT Equipments to be replace</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>1</p></div>
                        <div class="col-8 data-text">
                            <p>Pending technical support</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>2</p></div>
                        <div class="col-8 data-text">
                            <p>Ongoing technical support</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex flex-column">
                <div class="col data-header"><h3>Brand VS Repair</h3></div>
                <div class="col d-flex flex-row">
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>3</p></div>
                        <div class="col-8 data-text">
                            <p>Dell</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>1</p></div>
                        <div class="col-8 data-text">
                            <p>HP</p>
                        </div>
                    </div>
                    <div class="col data-card">
                        <div class="col-4 data-digit"><p>2</p></div>
                        <div class="col-8 data-text">
                            <p>Acer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/6952492a89.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script>
        const signout = () => {
            $.ajax({
                    url: 'signout.php',
                }).then((res) => {
                    if (res > 0) {
                        Swal.fire({
                            title: 'Success!',
                            text: "Signed out",
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then(()=>location.reload())
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: "An error occurred",
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        })
                    }
                }); 
        }
    </script>
</body>
</html>