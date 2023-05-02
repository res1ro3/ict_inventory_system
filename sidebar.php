<?php 

    if (!function_exists('base_url')){
        function base_url(){
        $url = sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );

        $url .= '/';

        return $url;
        }
    }

    $base_url = base_url();

?>
<style>
    .sidebar {
        background-color: #0056fb;
        width: 280px; 
        height: 100vh;
        box-shadow: rgba(0, 0, 0, 0.45) 25px 0px 20px -20px;
    }

    .sidebar ul li {
        padding: 10px 0px;
    }

    .sidebar ul li:hover {
        background-color: rgba(255, 255, 255, .5);
        border-radius: 5px;
    }
    .sidebar ul li:hover > a {
        color: #000;
    }

    .sidebar ul li a, .signout a  {
        font-size: 16pt;
    }

    .sidebar span, .sidebar ul li a, .sidebar hr, .signout a {
        color: #fff;
    }
</style>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
    <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
    <span class="fs-4">Dashboard</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo $base_url . "ict_inventory_system/admin/dashboard.php" ?>" class="nav-link link-body-emphasis">
            <i class="fa-solid fa-gauge"></i>
            Dashboard
            </a>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-current="page">
            <i class="fa-solid fa-boxes-stacked"></i>
            Inventory
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="<?php echo $base_url . "ict_inventory_system/inventory/manageInventory.php" ?>">View</a></li>
                <li><a class="dropdown-item" href="<?php echo $base_url . "ict_inventory_system/inventory/add.php" ?>">Add</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-current="page">
            <i class="fa-solid fa-list-check"></i>
            Services
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="#">View</a></li>
                <li><a class="dropdown-item" href="#">Add</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-current="page">
            <i class="fa-solid fa-users"></i>
            Employees
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="<?php echo $base_url . "ict_inventory_system/employee/manageAccounts.php" ?>">View</a></li>
                <li><a class="dropdown-item" href="<?php echo $base_url . "ict_inventory_system/employee/addEmployee.php" ?>">Add</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link link-body-emphasis">
            <i class="fa-solid fa-user"></i>
            Profile
            </a>
        </li>
    </ul>
    <hr>
    <div class="text-center signout">
        <a onclick="signout()" class="text-decoration-none" href="#">
        <i class="fa-sharp fa-solid fa-right-from-bracket"></i>
        Signout
        </a>
    </div>
</div>