<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$number1 = isset($_POST['number1']) ? $_POST['number1'] : '';
$number2 = isset($_POST['number2']) ? $_POST['number2'] : '';

if (strlen($name)>0 && strlen($feedback)>0 && strpos($email,"@") && is_numeric($number1) && is_numeric($number2) && ($number1)+($number2)== 10) {
print "Thank you for giving a feedback";
} else {
print "There was error in a form, please try again";    
}
?>