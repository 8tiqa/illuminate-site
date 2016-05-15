<?php

   
    session_start();    
    if (isset($_SESSION["username"])&isset($_SESSION["discussionID"])) {        
        
        $dID = $_SESSION['discussionID'];

         //CASE1: USER LIKED A POST
        if(isset($_GET['likeID'])){

        	$post =$_GET['likeID'];

        	// connect database
	        mysql_connect("localhost", "root", "") or die(mysql_error()); 
	        mysql_select_db("db_illuminate") or die(mysql_error()); 

	        //fetch number of likes
	        $query = "SELECT likes FROM tb_post WHERE ID ='".$post."'";
            $result = mysql_query($query) or die(mysql_error());            
            $discuss = array();
            while($row = mysql_fetch_assoc($result))
                $discuss[] = $row;

            //increment count
            $count = $discuss [0]['likes'];
            $count = $count +1;

            //update number of likes
            $queryy = "UPDATE tb_post SET likes = '".$count."' WHERE ID ='".$post."'"; 
            $resultt = mysql_query($queryy) or die(mysql_error());          


	        //return to discussion open
        	header("Location: discussion-open.php?open=".$dID."");
        }

        //CASE2: USER FLAGED A POST
        else if(isset($_GET['abuseID'])){

            $post =$_GET['abuseID'];

            // connect database
            mysql_connect("localhost", "root", "") or die(mysql_error()); 
            mysql_select_db("db_illuminate") or die(mysql_error()); 

            //fetch number of flags
            $query = "SELECT flags FROM tb_post WHERE ID ='".$post."'";
            $result = mysql_query($query) or die(mysql_error());            
            $discuss = array();
            while($row = mysql_fetch_assoc($result))
                $discuss[] = $row;

            //increment count
            $count = $discuss [0]['flags'];
            $count = $count +1;

            //update number of flags
            $queryy = "UPDATE tb_post SET flags = '".$count."' WHERE ID ='".$post."'"; 
            $resultt = mysql_query($queryy) or die(mysql_error());          


            //return to discussion open
            header("Location: discussion-open.php?open=".$dID."");
        }

        //CASE3: USER EDITED A POST
        else if(isset($_GET['editID'])){

            $post =$_GET['editID'];
            $newinput =$_POST['newinput'];

            // connect database
            mysql_connect("localhost", "root", "") or die(mysql_error()); 
            mysql_select_db("db_illuminate") or die(mysql_error()); 
            
            //update 
            $queryy = "UPDATE tb_post SET reply = '".mysql_real_escape_string($newinput)."' WHERE ID ='".$post."'"; 
            $resultt = mysql_query($queryy) or die(mysql_error());    


            //return to discussion open
            header("Location: discussion-open.php?open=".$dID."");
        }

        //CASE4: USER DELETED A POST
        else if(isset($_GET['deleteID'])){

            $post =$_GET['deleteID'];

            // connect database
            mysql_connect("localhost", "root", "") or die(mysql_error()); 
            mysql_select_db("db_illuminate") or die(mysql_error());             

            //update 
            $queryy = "DELETE FROM tb_post WHERE ID ='".$post."'"; 
            $resultt = mysql_query($queryy) or die(mysql_error());         


            //return to discussion open
            header("Location: discussion-open.php?open=".$dID."");
        }
    }



?>