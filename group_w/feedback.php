<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : ''; 
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = array("name" => "","email" => "", "feedback" => "","database" => "", "check" => "");

if($_POST){
    if(!empty($_POST['website'])) die(); //honeypot - if not empty - scrypt stop;

    if(strlen($name)>0 && strlen($feedback)>0 && strpos($email,"@") && strlen($name)<70 && $check==4) {

        // Attempt MySQL server connection to the db
        $conn = new mysqli('localhost','root','root','fullstack'); 
            //checking conection 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
        //no sql injection        
        $name = $conn->real_escape_string($name);
		$email = $conn->real_escape_string($email);
		$feedback = $conn->real_escape_string($feedback);
        
        //Write to the table 
        $saved = $conn->query("INSERT INTO `feedback`(`name`, `email`, `feedback`) VALUES ('$name','$email','$feedback')");
            if($saved){
                    header('Location:' . $_SERVER['PHP_SELF'] . '?success=OK'); 
            }else{ 
				$error['database'] = "Error when saving"; //if not save to DB
			}

    } else { //cheking input one by one
        if(strlen($name) == 0){
            $error['name'] = 'Error - Please fill name field!';
        }
        if(strlen($name) > 70){
            $error['name'] = 'Error - Max charakters reached!';
        }
        if(strlen($email) == 0){
            $error['email'] = 'Error - Please fill in email field!';
        }
        if(strlen($feedback) == 0){
            $error['feedback'] = 'Error - Please fill in feedback field!';
        }
        if($check !== 4){
            $error['check'] = 'Error - Please write correct answer!';
        }
    }
}
if(strlen($success) == 0) {

?>

<!<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>html->php->form->db</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="style.css" />-->
    <style>
        body {
            margin: 50px;
        }
        input[type=text], input[type=email], textarea {
            display: block;
            max-width: 300px;
            width: 30%;
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
            display: inline;
            font-weight: bold;
        }
        form #website{ display:none; } /*honeypot*/
    </style>
</head>
<body>
    <h1>Feedback</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        Name <span><?php echo $error['name']; ?></span><input type="text" name="name" placeholder="Add Name" 
            value="<?php echo $name;?>" />
        Email <span><?php echo $error['email']; ?></span><input type="email" name="email" placeholder="Add Email"
            value="<?php echo $email;?>"/>
        Feedback <span><?php echo $error['feedback']; ?></span><textarea name="feedback" placeholder="Add Your feedback"><?php echo $feedback;?></textarea>
        Security question: How many angles have a rectangle.  <span><?php echo  $error['check']; ?></span><input type="text" name="check" />
        <input type="text" id="website" name="website"/>
        <span><?php echo $error['database']; ?></span>
        <input type="submit" value="Save"/>
    </form>
</body>
</html>
<?php 
  } else {
	  print "OK feedback saved to DB";
  }
?>	  