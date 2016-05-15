 <!-- Add Discussion -->


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
       

    /* Add discussion*/ 
    $result = false; 
    

    if (isset($_POST["inputtopic"])&&isset($_POST["inputdetail"])) {    

        $dtopic = $_POST["inputtopic"];
        $ddetails =$_POST["inputdetail"];
        $dposted_by = $user;        
        
             
        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //insert discussion
        $query = "INSERT INTO tb_discuss (topic, details, posted_by) VALUES ('$dtopic', '$ddetails','$dposted_by')";
        $result = mysql_query($query);    

        
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
        var result =<?php echo json_encode($result); ?>;

        if(result) {
            $("#add-success").attr("class", "alert alert-danger unhide")
            $("#add-success").html('Your question has been added to the <a href="discussion-forum.php">Discussion Forum</a>!'); 

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
                            <form id="formLogin" class="form" role="form" action="discussion-addnew.php" method="POST">
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
                           <form role="form" action="ddiscussion-addnew.php" method="POST" 
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
                            <li><a href="discussionforum.php">Discussion Forum</a></li>
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


<!--Add new discussion-->
<div class="search-results">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <h3><span class="label label-info">Add New Discussion</span></h3>
                

                <div class="bs-callout bs-callout-info">
                    <form role="form" action="discussion-addnew.php" method="POST">

                            <div class="form-group">
                                <label>Type your Question Topic:</label>
                                <input class="form-control" id="inputtopic" name="inputtopic" required="">
                            </div>
                            <div class="form-group">

                                <label>Type your Question Details:</label>                                 
                                <textarea class="form-control" rows="5" id="inputdetail" name="inputdetail" required=""></textarea>
                            </div>
                            
                            <a class="btn btn-default" href="discussion-forum.php" role="button">
                                Cancel</a>
                            <input type ="submit" class="btn btn-danger" value="Submit">
                                
                    </form>
                            
                </div>
                <br><div class="alert alert-danger hide" role="alert" id="add-success"></div>
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
}


</script>

</body>
</html>
