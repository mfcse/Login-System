<?php
//PDO Connection
		$servername = "localhost";
		$db_username = "root";
		$db_password = "";
		$dbname = "crud";

		try {
		  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
		  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		  }
		catch(PDOException $e) {
		  echo "Error: " . $e->getMessage();
		}