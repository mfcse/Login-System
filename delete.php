 <?php
    session_start();
    if (!isset($_SESSION['id'], $_SESSION['username'])) {
        header('Location:login.php');
    }

    $errors = [];
    //die($_GET['id']);
    ##id check
    $id = $_GET['id'];
    if (!isset($id) || (int)$id === 0) {
        header('Location:users.php');
    }

    include_once 'connection.php';


    if (isset($_POST['delete'])) {

        $query = "DELETE FROM users WHERE id=:id";

        //pdo
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->rowCount();

        if ($row > 0) {
            $success = $row . ' User Deleted Successfully';
        } else {
            $errors[] = 'Not Deleted';
        }
    }

    include_once "header.php";
    ?>

 <div class="container">
     <div class="row">
         <div class="col-md-6 offset-md-3 mt-3">
             <h3>Edit</h3>
             <?php
                if (isset($success)) { ?>
             <p class="alert alert-warning"><?php echo $success; ?></p>
             <?php }
                ?>
             <form action="?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">

                 <div class="form-group">
                     <label for="username">Are You Sure to Delete thid User?</label>
                 </div>

                 <button type="submit" class="btn btn-primary" name="delete">Delete</button>
             </form>
         </div>
     </div>
 </div>
 <?php include_once "footer.php"; ?>