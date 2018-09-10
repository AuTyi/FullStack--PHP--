<?php
session_start(); //start session to set cookey;

$email = checkValue($_POST,'email');
$password = checkValue($_POST,'password');
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
    setcookie('rememberme', $cookie, time() + (87600 * 30));
	}


if($_POST && emailValid($email)){
    
    include('connect.php');// connect to the database;

       
    $email = $conn->real_escape_string($email);
    $result = $conn->query("SELECT * FROM `users` WHERE `email`='$email'");

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
        $login_error = "Error in login2";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>User -> login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="style.css" />-->
    <style>
                body {
            margin: 50px;
        }
        input[type=text], textarea, input[type=password] {
            display: block;
            min-width: 30%;
            margin: 20px 0;
            padding: 5px;
        }
        input[type=submit] {
            padding:5px 15px; 
            background:#ccc; 
            border:0 none;
            cursor:pointer;
            border-radius: 5px; 
        }
        span {
            color: red;
           
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>User login page</h2>
 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        
        Email <span><?php print ($_POST && !emailValid($email)) ? "Error ussername" : ""; ?></span>
            <input type="text" name="email" 
            value="<?php echo $email; ?>"/>
						        
		Password <input type="password" name="password" />
        <?php print $login_error; ?>
		<input type="submit" value="Login"/>
    </form>
</body>
</html>
<a href="logout.php">Logout</a>