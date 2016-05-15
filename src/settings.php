 <!-- Illuminate Settings Page -->

 <?php

    /*USER SESSION MAINTENANCE*/
    session_start();      

    $logged_in = 0;
    $error = 0;   
    $success =0;
    $user="";           
    
    if (isset($_SESSION["username"])) {
        
        $user = $_SESSION['username'];
        $logged_in = 1;

        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //fetch user info
        $query = "SELECT username, password, email, dob FROM tb_user WHERE username = '" .  $user . "'"; 
        $result = mysql_query($query) or die(mysql_error());        	
        $info = mysql_fetch_assoc($result);


        $updatedinfo = false;
        $updatedpass = false;
        $wrongpass = false;

       
        //change basic info
        if(isset($_POST["change-email"]) && isset($_POST["change-dob"])){

        	$newemail=$_POST["change-email"];
        	$newdob=$_POST["change-dob"];
        	
        	// connect database
	        mysql_connect("localhost", "root", "") or die(mysql_error()); 
	        mysql_select_db("db_illuminate") or die(mysql_error()); 

	        //update info
	        $query = "UPDATE tb_user SET email = '".$newemail."', dob = '".$newdob."' WHERE username ='".$user ."'"; 
	        $updatedinfo = mysql_query($query);  
        }           

        //change password
        $currentpass = $info['password'];  
        if(isset($_POST["current-password"])&& isset($_POST["new-password"])){
        	$newpass = $_POST["new-password"];
        	if($currentpass==$_POST["current-password"]){
        		//update info
		        $query = "UPDATE tb_user SET password = '".$newpass."' WHERE username ='".$user."'"; 
		        $updatedpass = mysql_query($query);  
        	}
        	else
        	{
        		$wrongpass = true;
        	}
        }      
        
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
        var res =<?php echo json_encode($info); ?>;

        $('#change-username').val(res['username']);
        $('#change-email').val(res['email']);
        $('#change-dob').val(res['dob']);    

        var info =<?php echo json_encode($updatedinfo); ?>;
        if(info){
        	$("#add-success").attr("class", "alert alert-info unhide");
            $("#add-success").html('Your info has been successfully updated!'); 
        } 

        var pass=<?php echo json_encode($updatedpass); ?>;
        if(pass){
        	$("#add-success").attr("class", "alert alert-info unhide");
            $("#add-success").html('Your password has been successfully changed!'); 
        } 
        
        var wrong=<?php echo json_encode($wrongpass); ?>;
        if(wrong)
        {
        	$("#add-success").attr("class", "alert alert-danger unhide");
            $("#add-success").html('Wrong password! Please re-enter your current password.'); 
        }      
	                
	});

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
                            <form id="formLogin" class="form" role="form" action="settings.php" method="POST">
                                <label>Login</label>
                                <input  class="form-control" id="token" type="hidden" value="DkL4m0y2-qafpDLd4cUY1jujMO8ePL7Tj36U" name="_csrf">
                                </input>
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
                            <form role="form" action="settings.php" method="POST" 
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




<!--Settings-->
<div class="change-setting">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">                 
                
                  <h3 id="change-settings-label"><span class="label label-primary"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</span></span></h3>
                  <br><div class="alert alert-info hide" role="alert" id="add-success"></div><br>

                 
                  <!-- Change basic information -->
                  <div class="bs-callout bs-callout-warning">
                    <h4> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Change your basic Account settings.</h4> 
                    <form class="form-horizontal" role="form" action="settings.php" method="POST">

                      <div class="form-group">
                        <label for="change-username" class="col-sm-5 control-label">Username</label>
                        <div class="col-sm-5">
                        	<input type="text" class="form-control" id="change-username" name="change-username" disabled=""> 
                        </div>                    
                      </div>
                      <div class="form-group">
                        <label for="change-email" class="col-sm-5 control-label">Email</label>
                        <div class="col-sm-5">
                          <input type="email" class="form-control" id="change-email" name="change-email" required="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="change-dob" class="col-sm-5 control-label">DOB</label>
                        <div class="col-sm-5">
                          <input type="text" class="form-control" id="change-dob" name="change-dob" required="">
                        </div>
                      </div>                                     
                                            
                      <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                          <input type="submit" class="btn btn-warning" value ="Save Changes">  
                        </div>
                      </div>                   

                    </form>                                   
                  </div> 

                  <!-- Change password -->
                  <div class="bs-callout bs-callout-danger">
                    <h4> <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Change your Password</h4> 
                    <form class="form-horizontal" role="form" action="settings.php" method="POST">
                        <div class="form-group">
	                        <label for="current-password" class="col-sm-5 control-label">Current Password</label>
	                        <div class="col-sm-5">
	                          <input class="form-control" id="current-password" name="current-password" required=""
	                          		type="password" placeholder="Please enter your current password">
	                        </div>
                      	</div> 
                      	<div class="form-group">
	                        <label for="new-password" class="col-sm-5 control-label">New Password</label>
	                        <div class="col-sm-5">
	                          <input class="form-control" id="new-password" name="new-password" required=""
	                          		type="password" placeholder="Please enter your new password">
	                        </div>
                      	</div> 
                      	<div class="form-group">
	                        <div class="col-sm-offset-5 col-sm-5">
	                          <input type="submit" class="btn btn-danger" value ="Save Changes">  
	                        </div>
	                    </div>         
                    </form>                                       
                  </div>

                  <!-- Public Profile-->
                  <!-- <div class="bs-callout bs-callout-info">
                    <h4> <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Change your Public Profile settings</h4> 
                    <form>
                        <input type="checkbox" name="show-email" id="show-email" value="1">
                        <label class="string optional" for="show-email"> Show my email address on my public profile.</label>
                        <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                          <button type="submit" class="btn btn-info">Save Changes</button>
                        </div>
                      </div>
                      <br>
                    </form>   
                  </div>-->                 


                </div>
        </div>       
    </div>
</div><!-- /Settings -->


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

<script>

	//Logging in
	var logged=<?php echo json_encode($logged_in); ?>;
	var usr= <?php echo json_encode($user); ?>;
	if(logged){
	    document.getElementById('menuLogin').setAttribute('class', 'dropdown hide');
	    document.getElementById('menuUser').setAttribute('class', 'dropdown unhide');
	    document.getElementById('lblUsername').innerHTML = usr;

	}	

</script>

</body>
</html>
