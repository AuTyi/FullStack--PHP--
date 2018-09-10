<?php

function checkValue($postArray,$key){
	return isset($postArray[$key]) ? $postArray[$key] : null;
}

function emailValid($email){
	return strpos($email, '@') > 0;
}
function passwordValid($password){
	return strlen($password) >=4;
}
function passwordsSame($password,$password_again){
	return $password == $password_again;
}

$email = checkValue ($_POST,'email');
$password = checkValue ($_POST, 'password');
$password_again = checkValue ($_POST, 'password_again');

if(emailValid($email) && passwordValid($password) && passwordsSame($password,$password_again)){
    include('connect.php');// connect to the database;

    $encrypt_password = password_hash($password, PASSWORD_DEFAULT);

    $saved = $conn->query("INSERT INTO `users` (`email`, `password`) 
		VALUES ('$email','$encrypt_password')");
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>User -> register</title>
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
    <h2>User registration page</h2>
 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        
        Email <span><?php print !emailValid($email) ? 'Error email' : ''; ?></span>
            <input type="text" name="email" 
            value="<?php echo $email; ?>"/>
						        
		Password <span><?php print !passwordValid($password) ? 'Error password to short' : ''; ?></span>
            <input type="password" name="password" 
            value="<?php echo $password; ?>"/>
            
        Password <span><?php print !passwordsSame($password,$password_again) ? 'Error password didnt match' : ''; ?></span>
            <input type="password" name="password_again" 
            value="<?php echo $password_again; ?>"/>
						        
		<input type="submit" value="create"/>
    </form>
</body>
</html>