<?php
$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
$fetch_error = false;
if (is_numeric($edit) && !$_POST) {

        $conn = new mysqli('localhost','root','root','fullstack'); // database conestion
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error); //conection check
            }
            
        $data = $conn->query("SELECT * FROM `blog` WHERE id=$edit");//select from table blog
            if($data && $data->num_rows >0){
                $row = $data->fetch_assoc();			
                $title = $row['title'];
                $author = $row['author'];
                $content = $row['content'];
                $success =  isset($_GET['success']) ? $_GET['success'] : '';
                $error = array("title" => "","author" => "", "content" => "", "database" => "");
    }else{
        $fetch_error = true;
    }

} else{
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $success =  isset($_GET['success']) ? $_GET['success'] : '';
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
				
            $conn = new mysqli('localhost','root','root','fullstack'); // database conestion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $title = $conn->real_escape_string($title);
            $author = $conn->real_escape_string($author);
            $content = $conn->real_escape_string($content);

                if(is_numeric($edit)){
                        $saved = $conn->query("UPDATE `blog` SET `title`='$title', `author`='$author', `content`='$content' 
                        WHERE id=$edit");    
                }else{
                        $saved = $conn->query("INSERT INTO `blog`(`title`, `author`, `content`) 
                        VALUES ('$title','$author','$content')");
                }

            if($saved){
                header('Location:' . $_SERVER['PHP_SELF'] . '?success=OK'); 
            } else {
                $error['database'] = "Error ehen saving";
            }
	} 
}	
    
    if(strlen($success) == 0) {
        
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
    <h2>Edit or add blog text</h2>

    <?php
			if($fetch_error == false){
		?>
        
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        
    Title <span><?php echo $error['title']; ?></span><input type="text" name="title"
			value="<?php echo $title; ?>"/>
			        
		Author <span><?php echo $error['author']; ?></span><input type="text" name="author"
			value="<?php echo $author; ?>"/>
			        
		Content <span><?php echo $error['content']; ?></span><textarea name="content">
			<?php echo $content; ?></textarea>
			
		<?php echo $error['database']; ?>
				
        <input type="submit" value="Save"/>

        <?php
			} else {
		?>
			<p>Error fetching updatable content</p>
		<?php
			} 
		?>

    </form>
</body>
</html>
<?php
	}else {
		print "Ok - your blog upgated";
	}
?>
