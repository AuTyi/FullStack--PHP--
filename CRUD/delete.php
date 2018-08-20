<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$checkd = isset($_GET['checkd']) ? $_GET['checkd']: null;

if($id != null && is_numeric ($id) && $checkd == "OK"){
        
        include('connect.php'); // connect to the database;

        $delete = $conn->query("DELETE FROM `blog` WHERE id=$id");

        if($delete){
            header('location: read.php');
        }

}else if($id != null && is_numeric ($id)){
    print "Do you realy want to remove this ID  " . $id . " entry ?";
    print '<a href="delete.php?id=' . $id . '&checkd=OK"> DELETE</a>';
}

?>