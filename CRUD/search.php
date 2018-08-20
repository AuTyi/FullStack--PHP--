<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
// gets value sent over search form

include('connect.php');// connect to the database

$search = $conn->real_escape_string($search);
//no SQL injection

if(strlen($search) > 0){
        $first_results = $conn->query("SELECT * FROM blog WHERE content LIKE '%$search%'");
        //// '%$query%' is what we're looking for, % means anything,

        if($first_results && $first_results->num_rows > 0){ // if one or more rows are returned 
            while($row = $first_results->fetch_assoc()){
                   echo '<h2><a href="read.php?id=' .$row['id'].'">' . $row['title'] . '</a></h2>';
					echo ' <a href="edit.php?edit=' . $row['id'] . '">Edit</a></h2>'; //link to edit file;
					echo ' <a href="delete.php?id=' . $row['id'] . '" rel="modal:open">Delete</a></h2>'; //link to delete file;
                    echo '<h3>Posted on ' . $row['date'] . '</h3>';
                    echo '<h5> Author ' . $row['author']. '</h5>';
					echo '<p>' .$row['content'] . '</p>';
            }

        }else{
            echo "No results"; //if no results;
        }
    }else{ //if query empthy
            echo "Please enter a search query!";
    }


?>
