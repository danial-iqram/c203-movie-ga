<?php
include ".\utils\config.php";

if (isset($protected) && $protected) {
    header("Location: login.php");
}

if (isset($_GET["logout"])) {
    logout();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title . " - Movie Reviews GA" ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-success navbar-dark sticky-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand fw-medium">🍿 Movie Reviews GA</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <!-- TODO: movie search -->
                        <!-- TODO: user profile-->
                        <?php 
                        if (isset($_SESSION["user"])) { 
                        ?>
                            <li class="nav-item dropdown" >
                                <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">My Account</a>
                                <ul class="dropdown-menu" style="margin: 0 -50px !important">
                                    <li><a href="settings.php" class="dropdown-item">Settings</a></li>
                                    <li><a href="?logout=true" class="dropdown-item">Logout</a></li>
                                </ul>
                            </li>
                        <?php 
                        } else { 
                        ?>
                            <li class="nav-item">
                                <a href="login.php" class="btn btn-primary">Login/Register</a>
                            </li>
                        <?php 
                        } 
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php include $page; ?>
    </body>
</html>