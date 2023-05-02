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
        <div class="container">
        <h3>As of Today</h3>
            <div class="data-group">
                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>No. of ICT Equipment to be replaced</p>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>No. of ICT Equipment per unit vs number of employees</p>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h1>10</h1>
                    </div>
                    <div>
                        <p>No. of pending/ongoing technical support</p>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>Information Systems</p>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>Remaining available communal ICT resources to be borrowed</p>
                    </div>
                </div>
            </div>
<!-- Brand vs No. of repair -->
            <h3>Brand vs Repair</h3>
            <div class="data-group">
                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>Dell</p>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h1>12</h1>
                    </div>
                    <div>
                        <p>HP</p>
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