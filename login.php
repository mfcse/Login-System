 <?php
	include_once "header.php";
	if (isset($_SESSION['id'], $_SESSION['username'])) {
		header('Location:users.php');
	}
	//session_start();
	//$errors=[];
	//sanitize
	function sanitize_input($content)
	{
		$content = trim($content);
		$content = stripslashes($content);
		$content = htmlspecialchars($content);
		return $content;
	}

	if (isset($_POST['login'])) {
		//$username=sanitize_input($_POST['username']);
		$identifier = sanitize_input($_POST['identifier']);
		$password = sanitize_input($_POST['password']);




		//validation
		// if(empty($username)){
		// 	$errors['username']='You must enter a valid username';
		// }

		if (empty($identifier)) {
			$errors['identifier'] = 'You must enter a valid email';
		}

		if (empty($password)) {
			$errors['password'] = 'You must enter a valid password';
		}


		if (empty($errors)) {

			//pdo connection 
			include_once 'connection.php';

			$sql = "SELECT * FROM `users` WHERE `email`=:identifier OR `username`=:identifier LIMIT 1";
			$stmt = $connection->prepare($sql);
			$stmt->bindParam(':identifier', $identifier);
			//$stmt->bindParam(':username',$username);
			$stmt->execute();


			if ($stmt->rowCount() === 1) {

				$data = $stmt->fetch();

				if (password_verify($password, $data['password'])) {
					$_SESSION['id'] = $data['id'];
					$_SESSION['username'] = $data['username'];
					$_SESSION['success'] = "User Logged in";

					header('Location:dashboard.php');
				} else {
					$errors[] = 'wrong password';
				}
			} else {
				$errors[] = 'User Not found';
			}
		}
	}


	?>

 <div class="container">
     <div class="row">
         <div class="col-md-6 offset-md-3 mt-3">
             <h3>Login</h3>
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
             <form action="" method="post" enctype="multipart/form-data">

                 <div class="form-group">
                     <label for="identifier">Email address</label>
                     <input type="text" name="identifier" class="form-control" id="identifier"
                         placeholder="Enter username or email">
                     <?php
						if (isset($errors['identifier'])) { ?>
                     <p class="alert alert-warning"><?php echo $errors['identifier'] ?></p>
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

                 <button type="submit" class="btn btn-primary" name="login">Login</button>
             </form>
             <p class="mt-4">New User? Please Register <a href="register.php">here</a></p>

         </div>
     </div>
 </div>
 <?php include_once "footer.php"; ?>