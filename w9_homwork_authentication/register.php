<?php  
include('include/config.php');//connect to database;

$errors = array(); 

function checkValue($postArray,$key){
	return isset($postArray[$key]) ? $postArray[$key] : null;
}
function nameValid($name){ //function test name entered;
	return strlen($name) > 0;
}
function emailValid($email){ //function test email have @;
	return strpos($email, '@') > 0;
}
function passwordValid($password){ //function test password length;
	return strlen($password) >=4;
}
function passwordsSame($password,$password_again){ //function test passwords mach;
	return $password == $password_again;
}

$name = checkValue ($_POST,'name');
$email = checkValue ($_POST,'email');
$password = checkValue ($_POST, 'password');
$password_again = checkValue ($_POST, 'password_again');

//check the database to make sure 
//a user does not already exist with the same username and/or email
$user_check_query = "SELECT * FROM `users` WHERE `name`='$name' OR `email`='$email' LIMIT 1";
$result = mysqli_query($conn, $user_check_query);
$user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['name'] === $name) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

if(nameValid($name) && emailValid($email) && passwordValid($password) && passwordsSame($password,$password_again)){
   
    $encrypt_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password beffor saving;

    $saved = $conn->query("INSERT INTO `users` (`name`, `email`, `password`) 
        VALUES ('$name','$email','$encrypt_password')");
    
    //mysqli_query($conn, $saved);
  	$_SESSION['username'] = $name;
  	//$_SESSION['success'] = "You are now logged in";
  	header('location: info.php');
}

?>

<?php require_once('include/header.php') ?>

<title>Register</title>

</head>
<body>
    <!-- container - wraps whole page -->
    <div class="container">
    <h2>User registration page</h2>
 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">

        <?php  if (count($errors) > 0) : ?>
            <span>
                <?php foreach ($errors as $error) : ?>
                   <p><?php echo $error ?></p>
                <?php endforeach ?>
                </span>
            <?php  endif ?>

        <label>Name </label><span><?php print !nameValid($name) ? 'Error - enter name' : ''; ?></span>
            <input type="text" name="name" 
            value="<?php echo $name; ?>"/>

        <label>Email </label><span><?php print !emailValid($email) ? 'Error email' : ''; ?></span>
            <input type="text" name="email" 
            value="<?php echo $email; ?>"/>
						        
		<label>Password </label><span><?php print !passwordValid($password) ? 'Error - password to short' : ''; ?></span>
            <input type="password" name="password" 
            value="<?php echo $password; ?>"/>
            
        <label>Password </label><span><?php print !passwordsSame($password,$password_again) ? 'Error - password didnt match' : ''; ?></span>
            <input type="password" name="password_again" 
            value="<?php echo $password_again; ?>"/>
						        
		<input type="submit" value="Register"/>
        <p>
  		Already a member? <a href="login.php">Sign in</a>
  	    </p>
    </form>
    </div>
</body>
</html>