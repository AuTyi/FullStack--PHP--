<?php
$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$fetch_error = false;
if (is_numeric($edit) && !$_POST) {

$conn = new mysqli('localhost','root','root','fullstack'); // database conestion
	if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
    }
    
$data = $conn->query("SELECT * FROM `blog` WHERE id=$edit");
$row = $data->fetch_assoc();			
print_r($row);
$title = $row['title'];
print $title;

} else{
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $success = isset($_GET['success']) ? $_GET['success'] : '';
    $error = array("title" => "","author" => "", "content" => "", "database" => "");
}
  if($_POST) {
	  if(strlen($title) == 0 || strlen($author) == 0 || strlen($content) == 0){
		  if(strlen($title) == 0){
					$error['title'] = 'Error';
		  }if(strlen($author) == 0){
					$error['author'] = 'Error';	
		  }if(strlen($content) == 0) {
					$error['content'] = 'Error';
		  }
	  }else {		  
				
				$saved = $conn->query("INSERT INTO `blog`(`title`, `author`, `content`) VALUES ('$title','$author','$content')");
				if($saved){
					header('Location:' . $_SERVER['PHP_SELF'] . '?success=OK'); 
				} else {
					$error['database'] = "Error ehen saving";
				}
	  } 
	}	
  
  
?>
<!<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>html->php->form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="style.css" />-->
    <style>
                body {
            margin: 50px;
        }
        input[type=text], textarea {
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
            display: inline;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Add blog text</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        
    Title <span><?php echo $error['title']; ?></span><input type="text" name="title"
			value="<?php echo $title; ?>"/>
			        
		Author <span><?php echo $error['author']; ?></span><input type="text" name="author"
			value="<?php echo $author; ?>"/>
			        
		Content <span><?php echo $error['content']; ?></span><textarea name="content"
			value="<?php echo $feedback;?>"></textarea>
			
		<?php echo $error['database']; ?>
			
		
        <input type="submit" value="Save"/>
    </form>
</body>
</html>
