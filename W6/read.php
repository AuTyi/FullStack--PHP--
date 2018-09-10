<?php
$item_id = isset($_GET['id']) ? $_GET['id'] : null;
$year_month = isset($_GET['month']) ? $_GET['month'] : null;

$conn = new mysqli('localhost','root','root','fullstack'); //connect to db
//checking conection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

$selection = "";

// Single item
if(is_numeric($item_id)){
	$selection = ' WHERE id=' . $item_id; 
}

// Month
if(strlen($year_month) > 0){
	list($year,$month) = explode('-',$year_month);
	$selection = ' WHERE month(date)=' . $month . ' AND year(date)=' . $year; 
}

$entries = $conn->query("SELECT * FROM blog" . $selection);
    
?>
<!doctype html>
<html>
	<head>
			<title>Blog create</title>
	</head>
	<body>
		<h2>Blog</h2>
		<?php
			if($entries && $entries->num_rows > 0){
				while($row = $entries->fetch_assoc()){
					echo '<h2><a href="read.php?id=' .$row['id'].'">' . $row['title'] . '</a></h2>';
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