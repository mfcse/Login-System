 <?php

	if (empty($errors)) {

		//PDO connection
		include_once 'connection.php';

		$sql = "SELECT id,username,email,profile_photo FROM `users`";

		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$data = $stmt->fetchAll();
	}

	?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
         integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>

 <body>
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
                     <?php	}
						?>


                 </table>
             </div>
         </div>
     </div>


     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
         integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
     </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
         integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
     </script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
         integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
     </script>
 </body>

 </html>