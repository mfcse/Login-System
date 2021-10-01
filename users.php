 <?php
    session_start();
    if (!isset($_SESSION['id'], $_SESSION['username'])) {
        header('Location:login.php');
    }

    if (empty($errors)) {

        //PDO connection
        include_once 'connection.php';

        $sql = "SELECT id,username,email,profile_photo FROM `users`";

        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
    }

    include_once "header.php";
    ?>

 <div class="container">
     <div class="row">
         <div class="col-md-8 offset-md-2 mt-3">
             <h3 class="mb-3">User list</h3>
             <?php
                if (isset($success)) { ?>
             <p class="alert alert-success"><?php echo $success; ?></p>
             <?php }

                if (isset($errors)) { ?>
             <p class="alert alert-warning">
                 <?php
                        foreach ($errors as $error) {
                            echo $error;
                        }
                        ?>

             </p>
             <?php }
                ?>
             <table class="table table-bordered table-hover">
                 <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Profile Photo</th>
                     <th>Action</th>
                 </tr>
                 <?php
                    foreach ($data as $user) { ?>
                 <tr>
                     <td><?php echo $user['id'] ?></td>
                     <td><?php echo $user['username'] ?></td>
                     <td><?php echo $user['email'] ?></td>
                     <td><img src="profile_photo/<?php echo $user['profile_photo'] ?>" width="80"></td>
                     <td>
                         <a href="edit.php?id=<?php echo $user['id'] ?>" class="badge badge-info">Edit</a>
                         <a href="delete.php?id=<?php echo $user['id'] ?>" class="badge badge-warning">Delete</a>
                     </td>
                 </tr>
                 <?php    }
                    ?>


             </table>
         </div>
     </div>
 </div>
 <?php include_once "footer.php"; ?>