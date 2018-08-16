<?php
$item_id = isset($_GET['id']) ? $_GET['id'] : null;
$year_month = isset($_GET['month']) ? $_GET['month'] : null;

$conn = new mysqli('localhost','root','root','fullstack'); //connect to db
//checking conection kill if error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

$selection = "";

// by single item
if(is_numeric($item_id)){
	$selection = ' WHERE id=' . $item_id; 
}

// by mnth
if(strlen($year_month) > 0){
	list($year,$month) = explode('-',$year_month);
	$selection = ' WHERE month(date)=' . $month . ' AND year(date)=' . $year; 
}

$entries = $conn->query("SELECT * FROM blog" . $selection); //select from table blog;
    
?>
<!doctype html>
<html>
	<head>
			<title>Blog read</title>
	</head>
	<body>
		<h2>Blog A</h2>
		<?php
			if($entries && $entries->num_rows > 0){
				while($row = $entries->fetch_assoc()){
					echo '<h2><a href="read.php?id=' .$row['id'].'">' . $row['title'] . '</a></h2>';
					echo ' <a href="edit.php?edit=' . $row['id'] . '">Edit</a></h2>'; //link to edit file;
                    echo '<h3>Date ' . $row['date'] . '</h3>';
                    echo '<h5> Author ' . $row['author']. '</h5>';
					echo '<p>' .$row['content'] . '</p>';
				}
			}else {
				echo '<p>Error: No entries</p>';
			}
		?>
	</body>
</html>