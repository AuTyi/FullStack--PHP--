<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<title>DEF CON 2018</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="normalize.css"/>
  		<link rel="stylesheet" type="text/css" href="styles.css"/>
		<style>
			form #website{ display:none; } /*honeypot*/
			input[type=submit] {
				background: #7EA2AA;
				border: none;
				color: #000000;
				cursor: pointer;
				text-transform: uppercase;
			}
			.popup {
				color: red;
				}
			.question {
				color:black;
				font-weight: normal;
				padding:10px;
				font-size:17px;
			}	
			
		</style>
	</head>	
	<body>
<!-- Aurimas section navigation start-->
<header>
	<nav>
	  <div class="nav-logo"><a href="index.html">DEFCON</a></div>
	  <ul>
		  <li><a href="index.html">Home</a></li>

		  <li>
			  <div class="dropdown">
				  <button class="dropbtn">Program <i class="fas fa-angle-double-right"></i></button>

				  <div class="dropdown-content dprogram">
					  <ul>
						  <li><a href="program.html">Speaker's</a></li>
						  <li><a href="program.html#schedule-section">Shedule</a></li>
						  <li><a href="program_contests_and_events.html">Contests &amp; Events</a></li>
					  </ul>
				  </div>
			  </div> 
		  </li>

		  <li>			
			  <div class="dropdown">
				  <button class="dropbtn"><a href="about.html">About<i class="fas fa-angle-double-right"></i></a></button>

				  <div class="dropdown-content dabout">
					  <ul>
						  <li><a href="contact.php">Contacts</a></li>
						  <li><a href="faq.html">FAQ</a></li>
						  <li><a href="policies.html">Policies</a></li>
					  </ul>
				  </div>
			  </div> 
		  </li>

		  <li><a href="index.html#recent-news">Recent news</a></li>
		  <li><a href="blog.html">Blog</a></li>
		  <li><a href="photos.html">Photos</a></li>
		  
	  </ul>
  </nav>
</header>
		<div class="fixedm"></div>
<!-- Aurimas section navigation end_Alex code begins here-->
		<!-- banner is hidden
        <section class="banner">
			<h1><a href="#">DEFCON</a></h1>
		</section>
		-->
		<!--Alex code begins here-->
		<section class="count">
			<div class="wrappy">
				<div class="seeu">See you in...</div>
				<div id="clock"></div>
				<button class="pirk">
					BUY NOW!
				</button>
			</div>
		</section>

		<!--Alex code ends here-->

        <!--Hamzat's code starts here-->
<!-- php script-Aurimas-->

<?php 
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$check = isset($_POST['check']) ? $_POST['check'] : ''; 
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = array("name" => "","email" => "", "feedback" => "","database" => "", "check" => "", "phone" => "", "subject" => "");

if($_POST){
    if(!empty($_POST['website'])) die(); //honeypot - if not empty - scrypt stop;
		//checked input conditions;
    if(strlen($name)>0 && strlen($feedback)>0 && strpos($email,"@") && strlen($name)<70 && $check==4 && strlen($phone) > 0 && strlen($subject) > 0 ) {
        	// attempt MySQL server connection to the db 'fullstack';
        $conn = new mysqli('localhost','root','root','fullstack'); 
            if ($conn->connect_error) {  
                die("Connection failed: " . $conn->connect_error);
                }
        	//testing for SQL injection;        
        $name = $conn->real_escape_string($name);
		$email = $conn->real_escape_string($email);
		$feedback = $conn->real_escape_string($feedback);
		$subject = $conn->real_escape_string($subject);
        $phone = $conn->real_escape_string($phone);
        $subject = $conn->real_escape_string($subject);
        	//write to the table `teamon`;
        $saved = $conn->query("INSERT INTO `teamone`(`name`, `email`, `feedback`, `phone`, `subject`) VALUES ('$name','$email','$feedback','$phone','$subject' )");
            if($saved){
                    header('Location:' . $_SERVER['PHP_SELF'] . '?success=OK'); 
            }else{ 
				$error['database'] = "Error when saving"; //display error if faill;
			}

    } else { //testing input one by one;
        if(strlen($name) == 0){
            $error['name'] = 'Error - Please fill in name field!';
        }
        if(strlen($name) > 70){
            $error['name'] = 'Error - Max charakters reached!';
        }
        if(strlen($email) == 0){
            $error['email'] = 'Error - Please fill in email field!';
        }
        if(strlen($phone) == 0){
            $error['phone'] = 'Error - Please fill in phone field!';
        }
        if(strlen($subject) == 0){
            $error['subject'] = 'Error - Please fill in subject field!';
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
		<section class="contact-us">
			<h2> CONTACT FORM</h2>
				<div class="contact-form">

					<div class="input-fields">
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
								<span class="popup"><?php echo $error['name']; ?></span></span><input type="text" class="input" name="name" placeholder="Name" 
									value="<?php echo $name;?>" />
								<span class="popup"><?php echo $error['email']; ?></span></span><input type="email" class="input" name="email" placeholder="Email Address"
									value="<?php echo $email;?>"/>
								<span class="popup"><?php echo $error['phone']; ?></span><input type="text" class="input" name="phone" placeholder="Phone"
									value="<?php echo $phone;?>"/>
								<span class="popup"><?php echo $error['subject']; ?></span><input type="text" class="input" name="subject" placeholder="Subject"
									value="<?php echo $subject;?>">
								<span class="question">Security question: How many angles have a rectangle?</span><span class="popup"><?php echo  $error['check']; ?></span><input type="text" class="input" name="check" />
								<input type="text" id="website" name="website"/>
								<span class="popup"><?php echo $error['database']; ?></span>
					</div>
						<div class="msg-c">
							<span class="popup"><?php echo $error['feedback']; ?></span><textarea name="feedback" placeholder="Add Your feedback"><?php echo $feedback;?></textarea>
							<div class="btn-c"><input type="submit" value="Send"/></div>
						</div>	
					</form>	
					</div>
				</div>	      
        </section>
<?php 
  } else {
	header('location: contact.php');
  }
?>	  
		<!--Hamzat's code ends here-->
		
		<!--Povilas form start-->

		<section class="form">
			<form class="question_form">
				<div class="left">
					<h2>Questions</h2>

					<label for="i_am">I am:</label>
					<select name="who" id="i_am">
						<option value="volunteer">Volunteer</option>
						<option value="participant">Participant</option>
						<option value="press">Press</option>
						<option value="other">Other</option>
					</select>	

					<label for="first_name">First Name</label>
					<input type="text" id="first_name">

					<label for="last_name">Last name</label>
					<input type="text" id="last_name">

					<label for="email">Email</label>
					<input type="email" id="email">	

					<label for="question">Question</label>				
					<textarea id="question"></textarea>

					<input id="sendBtn" class="cBTN" type="submit" value="send">		
				</div>	

				<div class="right">
					<h2>Newsletter</h2>

					<input id="subscribe" type="text" placeholder="Enter your mail address">

					<input id="subscribeBtn" class="cBTN" type="submit" value="subscribe">	
				</div>	
			</form>				
		</section>

		<!--Povilas form end-->
		<!--Povilas footer start-->
		<footer >
			<a class="stickyArrow" id="up" href="#" title="go up"><img src="icons/up3.png" alt="GO UP"></a> 	

			<div class="social-container"> 				
				<a href="#" title="Facebook"><img src="icons/f1.png" alt="Facebook"></a>
				<a href="#" title="Twiter"><img src="icons/t1.png" alt="Twiter"></a>
				<a href="#" title="LinkedIn"><img src="icons/l1.png" alt="LinkedIn"></a>
				<a href="#" title="Instagram"><img src="icons/i1.png" alt="Instagram"></a>
				<a href="#" title="Youtube"><img src="icons/y1.png" alt="Youtube"></a>               						
			</div> 
			   
			Powered by Team One CODE. All copyrights reserved.             					
		</footer>
		<!--Povilas form_footer end-->
		<!--scripts-->
		<script src="javascript/clock.js"></script>
		<script src="javascript/speakers.js"></script>
		<script src="shedule/js/modernizr.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
		<script>
			if( !window.jQuery ) document.write('<script src="js/jquery-3.0.0.min.js"><\/script>');
		</script>
		<script src="shedule/js/main.js"></script> <!-- Resource jQuery -->
			
	</body>
</html>






			
