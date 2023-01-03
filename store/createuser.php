<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create User</title>
</head>
<body>
	<?php
	if($_POST){

		include ("config.php");

		$username = $_POST['username'];
		$password = $_POST['password'];
		$img_name = $_FILES['avatar']['name'];
		$tmp_name = $_FILES['avatar']['tmp_name'];
		$img_error = $_FILES['avatar']['error'];

		if($img_error === 0){
			$img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ext_lc = strtolower($img_ext);

			$allowed_exts = array("jpg", "jpeg", "png", "webp");

			if(in_array($img_ext_lc, $allowed_exts)){
				$new_img_name = uniqid("ProPic-", true).'.'.$img_ext_lc;
				$img_upload_path = 'Assets/profilePic/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);

				$sql = "INSERT INTO `users` (username, password, role, avatarSrc) VALUES ('$username', '$password', 'user', '$new_img_name') ";
				if ($conn->query($sql) === TRUE) {
			      echo "<script> alert ('New user created successfully'); ";
			    } else {
			      echo "Error: " . $sql . "<br>" . $conn->error;
			    }



			}else{
				$err_msg = "Invalid File Type!";
				header("Location: createuser.php?error=$err_msg");
			}
		}else{
			echo "Error!";
		}

	}




	?>




	<form action="#" method="POST" enctype="multipart/form-data">
		<label for="username">Username:</label><br>
	    <input type="text" id="username" name="username" required><br><br>
	    <label for="avatar">Profile Picture:</label><br>
	    <input type="file" name="avatar"><br><br>
	    <label for="password">Password:</label><br>
	    <input type="password" id="pword" name="password" required><br>
	    <input type="checkbox" onclick="showPass()">Show Password <br><br><br>
	    
	    <input type="submit" value="Submit">
	</form>

	<br><br>

	<a href="login.php">Log In </a>

<script>
function showPass() {
  var x = document.getElementById("pword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

</body>
</html>