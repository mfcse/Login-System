<?php
include_once "header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-center mt-4">Welcome to Login System</h2>
            <p class="text-center mt-2">Developed using Core PHP, PDO Connection & MYSql Database</p>
            <?php
            //session_start();
            if (!isset($_SESSION['id'], $_SESSION['username'])) { ?>
            <p class="text-center"><a href="register.php">Register</a> or <a href="login.php">Login</a></p>
            <?php }
            ?>
        </div>
    </div>
</div>

<?php
include_once "footer.php";
?>