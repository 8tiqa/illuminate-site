<!-- Illuminate Discussion Forum -->

<?php

    /*USER SESSION MAINTENANCE*/
    session_start();      

    $logged_in = 0;
    $error = 0;   
    $success =0;
    $user="";    
       
    //CASE1: User is already logged in -> retrieve username
    if (isset($_SESSION["username"])) {
        
        $user = $_SESSION['username'];
        $logged_in = 1;
    }
    //CASE2: User logs in -> set username and password
    else if (isset($_POST['login-username']) && isset($_POST['login-password'])) {       
        
        // store the username and password the user entered
        $getuser = $_POST['login-username'];      
        $getpassword = $_POST['login-password'];  

        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        // fetch username and password from database and authenticate
        $query = "SELECT password FROM tb_user WHERE username = '" . mysql_real_escape_string($getuser) . "'"; 
        $result = mysql_query($query) or die(mysql_error());        
        $row = mysql_fetch_assoc($result);
        if ($getpassword == $row['password']) {       
            $_SESSION['username'] = $getuser;
            $_SESSION['password'] = $getpassword;
            $logged_in = 1;            
            $user = $_SESSION['username'];
        }
           
        else{
            $error=1;
        }

        
    }
    //CASE3: User signs in
    else if (isset($_POST['inputUsername'])&&isset($_POST['inputPassword']) &&isset($_POST['inputEmail']) &&isset($_POST['inputDOB']) ){       
        
        // store the info the user entered
        $getuser = $_POST['inputUsername'];
        $getpass = $_POST['inputPassword'];
        $getemail = $_POST['inputEmail'];
        $getdob = $_POST['inputDOB'];           

        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //insert discussion
        $query = "INSERT INTO tb_user (username, password, email, dob) VALUES ('$getuser', '$getpass', '$getemail', '$getdob')";
        $success = mysql_query($query); 
        if ($success) {       
            $_SESSION['username'] = $getuser;
            $_SESSION['password'] = $getpassword;
            $logged_in = 1;            
            $user = $_SESSION['username'];
        }       
        
    }

    //CASE4: User is not logged in
    else{
        session_destroy();
        $logged_in = 0;   
    }

    /* Input Search*/  
    

    if (isset($_GET["inputsearch"])) {    
        
        $search = $_GET["inputsearch"];
       
        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //fetch discussions
        $query = "SELECT ID, topic, details, posted_by, posted_on FROM tb_discuss WHERE topic LIKE '%" . $search . "%'"; 
        $result = mysql_query($query) or die(mysql_error());        	
        $discuss = array();
		while($row = mysql_fetch_assoc($result))
			$discuss[] = $row;



    }
        
    else{
        $search = "";
        
        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //fetch discussions
        $query = "SELECT ID, topic, details, posted_by, posted_on FROM tb_discuss"; 
        $result = mysql_query($query) or die(mysql_error());        	
        $discuss = array();
		while($row = mysql_fetch_assoc($result))
			$discuss[] = $row;
    }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Illuminate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Style Sheets -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="shortcut icon" href="img/favicon.png">

  <!-- jQuery&JavaScripts -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="http://code.jquery.com/qunit/qunit-1.10.0.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script type="text/javascript">
    
    $(document).ready(function(){

    	var total =0;
        var res =<?php echo json_encode($discuss); ?>;

	    for (var i = 0; i < res.length; i ++) {
	            listDiscuss (res [i] ['ID'], res [i]['topic'], res [i]['details'], res [i]['posted_by'], res [i]['posted_on'] ); 
	            total = i +1;	    
	    }

	    $("#results-alert").html( total + " Discussions Available.");
    });

    function listDiscuss (discuss_ID, topic, details, posted_by,posted_on) {  

    		/*
			<div class="bs-callout bs-callout-info">
                            <h4><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> What is Hijab? </h4>
                            <ul class="list-inline">                                
                                <li>Last Posted:</li>
                                <li id="last_posted">12/12/15</li>                       
                            </ul>                      

                            <p id="original_post">Original Post: Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden="true" attribute.If you're using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.</p>
                            <a href="discussion-forum.php?open=' . $id . '"class="btn btn-danger">Open Discussion</a>                     
                            
            </div>
    		*/          

            var DiscussDiv = $("<div> </div>").addClass ("bs-callout bs-callout-info");            

            var dtitle = $("<h4></4>").text (topic + " ");
              var dtitleSpan=$("<span></span>").addClass("glyphicon glyphicon-comment");
              dtitleSpan.attr("aria-hidden","true");              
              dtitle.append(dtitleSpan);
            DiscussDiv.append (dtitle);          
			
			var dpostedon = $("<ul></ul>").addClass("list-inline"); 
            var dpostedonli1 = $("<li></li>").text("Asked on:"); 
            var dpostedonli2 = $("<li></li>").text(posted_on); 

            dpostedon.append(dpostedonli1);
            dpostedon.append(dpostedonli2);

            var ddetails = $ ("<p> </p>").text(details);

            var dbtn = $("<a>Open Discussion</a>").addClass("btn btn-danger")         
            dbtn.attr ("href", "discussion-open.php?open="+discuss_ID);
            dbtn.attr ("role","button");

            
            DiscussDiv.append (dpostedon);
            DiscussDiv.append (ddetails);
            DiscussDiv.append (dbtn);

            $("#list-discuss").append (DiscussDiv);

        }

  </script>

</head>

<body>

<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand  -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>               
                <a class="navbar-brand" href="homepage.php">
                        <img alt="" src="img/apple-touch-icon-57-precomposed.png">
                </a>            

            </div>


            <!-- Nav links -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav nav-pills pull-right">
                    
                                       
                    <!--Login Menu-->
                    <li id="menuLogin" class="dropdown" >
                        <a id="navLogin" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Login/Sign up</a>
                        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                            <form id="formLogin" class="form" role="form" action="discussion-forum.php" method="POST">
                                <label>Login</label>
                                
                                <input  class="form-control" id="login-username" type="text" required="" placeholder="Username" name="login-username">
                                </input>
                                <input  class="form-control" id="login-password" type="password" required="" placeholder="Password" name="login-password">
                                </input>
                                
                                <input type="submit" class="btn btn-info" Value="Login" id="btnLogin">
                                <?php if($error){ ?>
                                   <script> alert ("Invalid Username/Password! Please re-enter.")</script>
                                <?php } ?>
                                <br></br>                           
                            </form>

                           
                            
                            <form>
                                <a data-toggle="collapse" href="#formRegister" aria-expanded="false" aria-controls="formRegister">
                                New User? Sign-up...
                                </a>                             
                                                                                                
                                <br></br>
                            </form>
                            <form role="form" action="discussion-forum.php" method="POST" 
                                  id="formRegister" class="form collapse" style="height: auto;">
                            
                                <input  class="form-control" id="inputUsername" name="inputUsername" required="" type="text" placeholder="Username"></input>
                                <input  class="form-control" id="inputPassword" name="inputPassword" type="password" required="" placeholder="Password" ></input>
                                <input  class="form-control" id="inputEmail" name="inputEmail" type="email" required="" placeholder="Email"></input>
                                <input  class="form-control" id="inputDOB" name="inputDOB" type="text" required="" placeholder="DOB"></input>

                                <input type="checkbox" name="agreement" id="agreement" value="1" required>
                                <label class="string optional" for="agreement">Agree to Terms</label>
                                
                                <input type="submit" class="btn btn-primary" value="Sign Up">
                                <br></br>
                                <br></br>   
                                
                                
                            </form>
                        </div>
                    </li><!--/Login Menu-->
                    
                    <!--User Menu > Settings/Log Out-->
                    <li id="menuUser" class="dropdown hide">
                        <a class="dropdown-toggle" title="Change your Account Settings" data-toggle="dropdown" href="#">

                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <span id="lblUsername">tasneemkausar</span>
                            <b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="homepage.php">Home</a></li>
                            <li><a href="discussion-forum.php">Discussion Forum</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li class="divider"></li>                            
                            <li><a href="logout.php">Logout</a></li>
                                                  
                        </ul>
                    </li><!--/User Menu-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>




<!--Discussions-->
<div class="search-results">
    <div class="container">

        
        
        <!-- Search Query -->          
            <div class="row clearfix">
                <div class="col-md-10 column">                
                    <form id="formSearch" class="form" role="form" action="discussion-forum.php" method="GET">                        

                        <div class="input-group">    		

                          <input id="inputsearch" type="text" class="form-control" name="inputsearch">
                          <script>
                                var squery= <?php echo json_encode($search); ?>;
                                document.getElementById('inputsearch').value = squery;

                          </script>

                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"
                                data-toggle="tooltip" data-placement="top" title="Search Forum">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                          </span>

                        </div><!-- /input-group -->
                    </form>
                </div>
                <div class="col-md-2 column">
                	<a class = "btn btn-danger hide"  href ="discussion-addnew.php" role ="button" id="add-new">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add New Discussion </a> 
                </div>

            </div>

        <!-- Discussions -->
        <div class="row clearfix">
            <div class="col-md-12 column" >
            	<br><div class="alert alert-info" role="alert" id="results-alert"></div>
            	<form action="discussion-open.php" method="GET">
                	<div id="list-discuss"></div>       
                </form>             
            </div> 
        </div>

        
    </div>
</div><!-- /Discussions -->


<!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <ul class="list-inline">
                        
                        <li>
                            <a href="about.php">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="terms.php">Terms</a>
                            
                        </li>
                         <li class="footer-menu-divider">&sdot;</li>
                        <li>
                             <a href="about.php#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy;Illuminate 2015. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
<!--/footer-->

<script type="text/javascript">

//Logging in
var logged=<?php echo json_encode($logged_in); ?>;

if(logged){
    var usr= <?php echo json_encode($user); ?>;
    document.getElementById('menuLogin').setAttribute('class', 'dropdown hide');
    document.getElementById('menuUser').setAttribute('class', 'dropdown unhide');
    document.getElementById('lblUsername').innerHTML = usr;
    document.getElementById('add-new').setAttribute('class', 'btn btn-danger unhide');
    
}


</script>

</body>
</html>
