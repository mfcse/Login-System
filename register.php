 <?php

	$errors = [];
	//sanitize
	function sanitize_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if (isset($_POST['register'])) {
		$username = sanitize_input($_POST['username']);
		$email = sanitize_input($_POST['email']);
		$password = password_hash(sanitize_input($_POST['password']), PASSWORD_BCRYPT);
		//$password=sha1(sanitize_input($_POST['password']));
		$profile_photo = ($_FILES['file']);



		//validation
		if (empty($username)) {
			$errors['username'] = 'You must enter a valid username';
		}

		if (empty($email)) {
			$errors['email'] = 'You must enter a valid email';
		}

		if (empty($password)) {
			$errors['password'] = 'You must enter a valid password';
		}
		if (empty($profile_photo)) {
			$errors['file'] = 'You must upload a valid file';
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$errors['email'] = 'You must enter a valid email';
		}
		if (strlen($password) < 6) {

			$errors['password'] = 'You must enter a  password containg at least 6 characters';
		}



		if (empty($errors)) {

			//file upload
			$file_data = explode('.', $profile_photo['name']);
			$file_ext = end($file_data);

			$new_file_name = uniqid('pp_', true) . '.' . $file_ext;
			$upload = move_uploaded_file($profile_photo['tmp_name'], 'profile_photo/' . $new_file_name);

			if ($upload) {
				//db insert

				//PDO Connection
				include_once 'connection.php';

				$query = "INSERT INTO `users` (`username`,`email`,`password`,`profile_photo`) VALUES(:username,:email,:password,:profile_photo)";
				$stmt = $connection->prepare($query);

				//bind parameters
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':password', $password);
				$stmt->bindParam(':profile_photo', $new_file_name);

				//var_dump($stmt->execute());

				// // set the resulting array to associative
				// $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				// foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
				//   echo $v;

				if ($stmt->execute() === false) {
					$success = "User was not inserted";
				} else {
					$errors[] = "User inserted successfully";
				}
			} else {
				$errors['file'] = 'File was not uploaded';
			}
		}
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
             <div class="col-md-6 offset-md-3 mt-3">
                 <h3>Register</h3>
                 <?php
					if (isset($success)) { ?>
                 <p class="alert alert-warning"><?php echo $success; ?></p>
                 <?php }
					?>
                 <form action="" method="post" enctype="multipart/form-data">

                     <div class="form-group">
                         <label for="username">User Name</label>
                         <input type="text" name="username" class="form-control" id="username"
                             placeholder="Enter username">
                     </div>
                     <div class="form-group">
                         <label for="exampleInputEmail1">Email address</label>
                         <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                             placeholder="Enter email">
                         <?php
							if (isset($errors['email'])) { ?>
                         <p class="alert alert-warning"><?php echo $errors['email'] ?></p>
                         <?php }
							?>

                     </div>
                     <div class="form-group">
                         <label for="exampleInputPassword1">Password</label>
                         <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                             placeholder="Password">
                         <?php
							if (isset($errors['password'])) { ?>
                         <p class="alert alert-warning"><?php echo $errors['password'] ?></p>
                         <?php }
							?>
                     </div>
                     <div class="form-group">
                         <label for="file">Profile Photo</label>
                         <input type="file" name="file" class="form-control" id="exampleInputfile">
                         <?php
							if (isset($errors['file'])) { ?>
                         <p class="alert alert-warning"><?php echo $errors['file'] ?></p>
                         <?php }
							?>
                     </div>

                     <button type="submit" class="btn btn-primary" name="register">Register</button>
                 </form>
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