<?php
$name = isset($_POST['name']) ? $_POST['name'] : '';

$conn = new mysqli('localhost','root','root','feedback');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

$saved = $conn->query("INSERT INTO `feedback`(`name`, `email`, `feedback`) 
        VALUES ('$name','$email','$feedback')");


print_r($conn);
?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">

<input type="text" name="name"/>

</form>