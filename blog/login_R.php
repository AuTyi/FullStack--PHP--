<?php
	session_start();	
	$email = checkValue($_POST,'email');
	$password = checkValue($_POST,'password');
	$login_error = "";

	function checkValue($postArray,$key){
		return isset($postArray[$key]) ? $postArray[$key] : null;
	}

	function emailValid($email){
		return strpos($email,'@') > 0;
	}

	function GenerateRandomToken(){
		$token = openssl_random_pseudo_bytes(16);
		$token = bin2hex($token);
		return $token;
	}

	function storeTokenForUser($user, $id, $token, $conn){
		
		$conn->query("INSERT INTO `tokens` (`user_id`,`token`) VALUES ('$id','$token')");
		print $conn->error;
	}

	function onLogin($user,$id,$conn) {
		$secret_key = "SECRET";
    $token = GenerateRandomToken(); 
    storeTokenForUser($user,$id, $token, $conn);
    $cookie = $user . ':' . $token;
    $mac = hash_hmac('sha256', $cookie, $secret_key);
    $cookie .= ':' . $mac;
    setcookie('rememberme', $cookie, time() + (87600 * 30));
	}

	if($_POST && emailValid($email)){

        include('connect.php');// connect to the database;
        
		$email = $conn->real_escape_string($email);
		$result = $conn->query("SELECT * FROM `users` WHERE 'email'='$email'");
        
        print $conn->error;

		if($result->num_rows > 0){
			$user = $result->fetch_assoc();
			if(password_verify($password,$user['password'])){
				$_SESSION['username'] = $email;
				onLogin($email,$user['id'], $conn);
			}else {
				$login_error = "Error in login1";
			}
		}else {
			$login_error = "Error in login0";
        }
        
	}
?>
<?php print $_SESSION['username']; ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input name="email" type="text" value="<?php echo $email; ?>"/>
	<?php print ($_POST && !emailValid($email)) ? "Error" : ""; ?>
	<input name="password" type="password" />
	<?php print $login_error; ?>
	<input type="submit" value="Login" />
</form>
<a href="logout.php">Logout</a>