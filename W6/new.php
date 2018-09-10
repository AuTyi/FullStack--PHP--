<?php

include 'Users.php';
$usersObject = new Users();
$usersObject->addUser("Karolina"); // Class has function addUser;
$users = $usersObject->users; // Class has also a variable users;
print_r($users); // Prints Karolina
print "<br/>";
print_r($usersObject->users); // Prints Karolina
print "<br/>";


?>
