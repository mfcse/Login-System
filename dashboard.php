 <?php
    include_once "header.php";
    //session_start();
    if (!isset($_SESSION['id'], $_SESSION['username'])) {
        header('Location:index.php');
    }

    //include_once "header.php";
    ?>

 <div class="container">
     <div class="row">
         <div class="col-md-6 offset-md-3 mt-3">
             <h3 class="text-center">You are logged in as <?php echo $_SESSION['username'] ?></h3>

             <a href="logout.php" class="btn btn-danger btn-block">Logout</a>

         </div>
     </div>
 </div>
 <?php include_once "footer.php"; ?>