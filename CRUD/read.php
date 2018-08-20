<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$year_month = isset($_GET['month']) ? $_GET['month'] : null;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entries_per_page = 3;

//$search = isset($_GET['search']) ? $_GET['search'] : null;

include('connect.php');// connect to the database

$selection = "";

// by single item
if(is_numeric($id)){
	$selection = ' WHERE id=' . $id; 
}

// by mnth
if(strlen($year_month) > 0){
	list($year,$month) = explode('-',$year_month);
	$selection = ' WHERE month(date)=' . $month . ' AND year(date)=' . $year; 
}

$all_entries = $conn->query("SELECT * FROM blog ORDER BY date desc" . $selection); //select all ;
$entries = $conn->query("SELECT * FROM blog ORDER BY date desc" . $selection . 
			" LIMIT ". ($page-1)*$entries_per_page . " , " . $entries_per_page); //select per page;

//if(strlen($search) > 0){
//	$conn->query("SELECT * FROM blog_entries WHERE content LIKE '%$search%'");
//}

?>
<!doctype html>
<html>
	<head>
			<title>Blog Test</title>
				<!-- Remember to include jQuery :) -->
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

				<!-- jQuery Modal -->
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
	</head>
	<body>
		<h2>Blog</h2>
		<hr>
		<form method="GET" action="search.php">
        
		<input type="text" name="search"/>
					
	    <input type="submit" name="submit" value="Search"/>
        
    </form>
    </form>
		<hr>
		<?php
			if($entries && $entries->num_rows > 0){
				while($row = $entries->fetch_assoc()){
					echo '<h2><a href="read.php?id=' .$row['id'].'">' . $row['title'] . '</a></h2>';
					echo ' <a href="edit.php?edit=' . $row['id'] . '">Edit</a></h2>'; //link to edit file;
					echo ' <a href="delete.php?id=' . $row['id'] . '" rel="modal:open">Delete</a></h2>'; //link to delete file;
                    echo '<h3>Posted on ' . $row['date'] . '</h3>';
                    echo '<h5> Author ' . $row['author']. '</h5>';
					echo '<p>' .$row['content'] . '</p>';
				}
				$max_page = ceil($all_entries->num_rows/$entries_per_page);
				for($n=1; $n <= $max_page; $n++){
					$active = ($page == $n) ? "classname='active'" : "";
					echo '<a href="read.php?page=' . $n . '" ' . $active . '>' . $n . '</a>';
				}
			}else {
				echo '<p>Error: No entries</p>';
			}
		?>
	</body>
</html>