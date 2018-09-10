<?php
$item_id = isset($_GET['id']) ? $_GET['id'] : null;
$year_month = isset($_GET['month']) ? $_GET['month'] : null;
$conn = new mysqli('localhost','root','root','fullstack'); // Here your database 
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
$entries = $conn->query("SELECT * FROM blog " . $selection);
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
					echo '<h2><a href="read.php?id=' . $row['id'] . '">' . $row['title'] . '</a>';
					echo ' <a href="edit-6.php?edit=' . $row['id'] . '">Edit</a></h2>';
					echo '<h3>' . $row['date'] . ' ' . $row['author']. '</h3>';
					echo '<div>' .$row['content'] . '</div>';
				}
			}else {
				echo '<p>Error: No entries</p>';
			}
		?>
	</body>
</html>