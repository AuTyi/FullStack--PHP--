<?php
include('include/config.php');//connect to database

$name = "";
$email = checkValue($_POST,'email');
$password = checkValue($_POST,'password');
//$remember = isset($_POST['remember']) ? $_POST['remember'] : '';
$login_error = '';

function checkValue($postArray,$key){
	return isset($postArray[$key]) ? $postArray[$key] : null;
}

function emailValid($email){
	return strpos($email, '@') > 0;
}

function GenerateRandomToken(){ //will generate token;
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);
    return $token;
}
    
function storeTokenForUser($user, $id, $token, $conn){ //save token to db;
		
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
    setcookie('rememberme', $cookie, time() + (87600 * 14)); //remember user for two weeks;
	}


if($_POST && emailValid($email)){
       
    $email = $conn->real_escape_string($email);
    $result = $conn->query("SELECT * FROM `users` WHERE `email`='$email' ");

    print $conn->error;

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password,$user['password'])){
            $_SESSION['username'] = $email;

            if (isset($_POST['remember'])) { //rememebr me cheked 
            onLogin($email,$user['id'], $conn);
            }

            if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $email;
            $_SESSION['success'] = "You are now logged in";
            header('location: info.php');   
            }

        }else {
            $login_error = "Error in login - check your password";
        }
    }else {
        $login_error = "Error in login - check your name or password";
    
    }
    

}

?>

<?php require_once('include/header.php') ?>

    <title>User -> login</title>
</head>
<body>
    <!-- container - wraps whole page -->
	<div class="container">
    <h2>User login page</h2>
 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        
        <label>Email </label><span><?php print ($_POST && !emailValid($email)) ? "Error username" : ""; ?></span>
            <input type="text" name="email" 
            value="<?php echo $email; ?>"/>
						        
		<label>Password </label><input type="password" name="password" />
       	<input type="submit" value="Login"/>
        <input type="checkbox" name="remember" value="yes"/> <label>Remember me</label><br>
        <p>
				Not yet a member? <a href="register.php">Sign up</a>
			</p>
        <span><?php print $login_error; ?></span>
    </form>
    </div>
</body>
</html>