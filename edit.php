 <?php
	//session_start();
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

	//sanitize
	function sanitize_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if (isset($_POST['update'])) {
		$username = sanitize_input($_POST['username']);
		$email = sanitize_input($_POST['email']);
		$profile_photo = ($_FILES['file']);


		//validation
		if (empty($username)) {
			//var_dump($username);
			$errors['username'] = 'You must enter a valid username';
		}

		if (empty($email)) {
			//var_dump($email);
			$errors['email'] = 'You must enter a valid email';
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$errors['email'] = 'You must enter a valid email';
		}

		if (empty($errors)) {
			if (isset($profile_photo['name'])) {
				//file upload
				$file_data = explode('.', $profile_photo['name']);
				$file_ext = end($file_data);

				if (!in_array($file_ext, ['jpg', 'png'], true)) {
					$errors['profile_photo'] = 'file must be a valid image file';
				}

				if (!isset($errors['profile_photo'])) {
					$new_file_name = uniqid('pp_', true) . '.' . $file_ext;
					$upload = move_uploaded_file($profile_photo['tmp_name'], 'profile_photo/' . $new_file_name);

					$query = "UPDATE users SET profile_photo='$new_file_name' WHERE id=:id";

					//die(var_dump($connection));

					$stmt = $connection->prepare($query);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
				}

				$userQuery = "UPDATE users SET username='$username',email='$email' WHERE id=:id";
				//die(var_dump($connection));
				$stmt1 = $connection->prepare($userQuery);
				$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
				//$stmt1->execute();

				if (($stmt1->execute()) === true) {
					$success = 'User Updated Successfully';
				} else {
					$errors[] = 'User Not Updated';
				}
			}
		}
	}


	if (!isset($errors['connection'])) {

		$query = "SELECT id,username,email,profile_photo FROM users WHERE id=:id";


		$stmt = $connection->prepare($query);
		// die(var_dump($connection));
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$data = $stmt->fetch();
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
                     <label for="username">User Name</label>
                     <input type="text" name="username" class="form-control" id="username"
                         value="<?php echo $data['username'] ?>">
                 </div>
                 <?php
					if (isset($errors['username'])) { ?>
                 <p class="alert alert-warning"><?php echo $errors['username'] ?></p>
                 <?php }
					?>
                 <div class="form-group">
                     <label for="email">Email address</label>
                     <input type="email" name="email" class="form-control" id="email"
                         value="<?php echo $data['email'] ?>">
                     <?php
						if (isset($errors['email'])) { ?>
                     <p class="alert alert-warning"><?php echo $errors['email'] ?></p>
                     <?php }
						?>

                 </div>

                 <div class="form-group">
                     <label for="file">Profile Photo</label>
                     <input type="file" name="file" class="form-control" id="exampleInputfile"
                         value="<?php echo $data['profile_photo'] ?>">
                     <?php
						if (isset($errors['file'])) { ?>
                     <p class="alert alert-warning"><?php echo $errors['file'] ?></p>
                     <?php }
						?>
                 </div>

                 <button type="submit" class="btn btn-primary" name="update">Update</button>
             </form>
         </div>
     </div>
 </div>

 <?php include_once "footer.php"; ?>