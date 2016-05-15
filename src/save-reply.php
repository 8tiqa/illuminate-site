<?php

    /*USER SESSION MAINTENANCE*/
    session_start();    
    if (isset($_SESSION["username"])&isset($_SESSION["discussionID"])) {
        
        $user = $_SESSION['username'];
        $dID = $_SESSION['discussionID'];

        if(isset($_POST['inputreply'])){

        	$post =$_POST['inputreply'];

        	// connect database
	        mysql_connect("localhost", "root", "") or die(mysql_error()); 
	        mysql_select_db("db_illuminate") or die(mysql_error()); 

	        //insert reply post
	        $query = "INSERT INTO tb_post (D_ID, reply, posted_by, likes, flags) VALUES ('$dID', '$post','$user','0','0')";
	        $result = mysql_query($query) or die(mysql_error());
	        
	        //return to discussion open
        	header("Location: discussion-open.php?open=".$dID."");
        }
    }



?>