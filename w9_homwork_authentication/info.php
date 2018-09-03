<?php 
include('include/config.php');//connect to database
  
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }

  //get name from db to display;
  $em = $_SESSION['username'];
  $result = $conn->query("SELECT `name` FROM `users` WHERE `email` = '$em' ");
  if($result->num_rows > 0){
	$user = $result->fetch_assoc();
	$_SESSION['us'] = $user['name'];
  }
 
?>
<?php require_once('include/header.php') ?>

<title>Blog -> register</title>

</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['us']; ?></strong></p>
		
    	<p> <a href="logout.php?logout='1'" style="color: red;">Logout</a> </p>
    <?php endif ?>
</div>
		
</body>
</html>
