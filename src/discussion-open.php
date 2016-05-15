 <!-- Open Discussion -->

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
    $done =0;  
    

    if (isset($_GET["open"])) {    
          $dID = $_GET["open"];
          $_SESSION["discussionID"]=$dID;
          $done =1;     
                 
          // connect database
          mysql_connect("localhost", "root", "") or die(mysql_error()); 
          mysql_select_db("db_illuminate") or die(mysql_error()); 

          //fetch original post      
          $query = "SELECT ID, topic, details, posted_by, posted_on FROM tb_discuss WHERE ID  = '" . $dID . "'";
          $result = mysql_query($query) or die(mysql_error());  
          $discuss = array();
          while($row = mysql_fetch_assoc($result))
            $discuss[] = $row;
            
          

          //fetch reply posts
          $query = "SELECT ID, reply, posted_by, posted_on, likes, flags FROM tb_post WHERE D_ID = '" . $dID . "'";
          $result = mysql_query($query) or die(mysql_error()); 
          $post = array();        
          while($row = mysql_fetch_assoc($result))
            $post[] = $row;
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
        var done = <?php echo json_encode($done); ?>;
        if(done){

          var res =<?php echo json_encode($discuss); ?>;
          for (var i = 0; i < res.length; i ++) {
              listDiscuss (res [i] ['ID'], res [i]['topic'], res [i]['details'], res [i]['posted_by'], res [i]['posted_on'] );                       
          }             
          
          var ras =<?php echo json_encode($post); ?>;
          for (var i = 0; i < ras.length; i ++) {
              listpost(ras [i] ['ID'], ras [i]['reply'], ras [i]['posted_by'], ras [i]['posted_on'], ras [i]['likes'],ras [i]['flags'] );                           
          }
        }
    });

     function listDiscuss (discuss_ID, topic, details, posted_by, posted_on) { 

        
            /*<!-- Original Post-->
                <div class="original-post">
                  <h3 id="original-post-question"><span class="label label-primary">What is Hijab?</span></h3>
                  <div class="bs-callout bs-callout-info">
                      <h4> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Question Details </h4> 
                      <p id="original-post-details">Original Post: Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden="true" attribute.If you're using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.</p>

                      <br>
                      <div class="btn-group" role="group">
                        <button id="reply-posted-by" type="button" class="btn btn-default">Tasneem Kausar</button>
                        <button id="reply-posted-on" type="button" class="btn btn-default disabled">24/12/13</button>
                        
                      </div>                  
                  </div>
                </div><!-- /Original Post-->
            */               

            var dtopic= $("<h3></h3>");
            /*
            var dtopicSpan1=$("<a><span class='glyphicon glyphicon-circle-arrow-left' aria-hidden='true'></span></a>");
            dtopicSpan1.attr("href","discussion-forum.php")
            dtopic.append(dtopicSpan1);
            */
            

            var dtopicSpan2=$("<span></span>").addClass("label label-primary");
            dtopicSpan2.text(topic);
            dtopic.append(dtopicSpan2);
            $("#original-post").append (dtopic);

            var OP = $("<div> </div>").addClass ("bs-callout bs-callout-info");  

            var dtitle = $("<h4></h4>").text("Question Details  ");
              var dtitleSpan=$("<span></span>").addClass("glyphicon glyphicon-comment");
              dtitleSpan.attr("aria-hidden","true");              
            dtitle.append(dtitleSpan);

            var ddetails =$("<p></p>").text(details);

            var dbtns = $("<div></div>").addClass("btn-group");
            dbtns.attr("role","group");
              
              var btn1= $("<button></button>").addClass("btn btn-default");
              btn1.attr("id","reply-posted-by");
              btn1.text(posted_by);
              
              var btn2= $("<button></button>").addClass("btn btn-default disabled");
              btn2.attr("id","reply-posted-on");
              btn2.text(posted_on);
            dbtns.append(btn1);
            dbtns.append(btn2);

            OP.append (dtitle);
            OP.append(ddetails);
            OP.append ("<br>");  
            OP.append (dbtns);                 
            
            $("#original-post").append(OP);

        }

      function listpost (ID, reply, posted_by, posted_on, likes, flags ) {

        
          /*<!-- Reply Post-->
                <div id="reply-post"> 
                    <div class="bs-callout bs-callout-warning">
                      <h4> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Reply </h4> 
                      
                      <p>Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. Them with the aria-hidden="true" attribute.If you're using an icon to convey meaning (rather than only as a decorative element), ensure that this mean.</p>
                      <br>                     

                      <div class="btn-group" role="group">
                        <button id="reply-posted-by" type="button" class="btn btn-default">Tasneem Kausar</button>
                        
                        
                        <button id="reply-posted-on" type="button" class="btn btn-default disabled">24/12/13</button>
                        <button id="reply-like" type="button" class="btn btn-default">
                          <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                        </button>                        
                        <button id="reply-report-abuse" type="button" class="btn btn-default">
                          <span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
                        </button>
                        //<edit button>
                        //<delete button>
                      </div>     
                    </div>                                       
                </div> <!-- /Reply Post-->
        */

            var DiscussDiv = $("<div> </div>").addClass ("bs-callout bs-callout-warning");  

            var dtitle = $("<h4></4>").text("Reply  ");
              var dtitleSpan=$("<span></span>").addClass("glyphicon glyphicon-comment");
              dtitleSpan.attr("aria-hidden","true");
            dtitle.append(dtitleSpan);

            var ddetails =$("<p></p>").text(reply);

            var dbtns = $("<div></div>").addClass("btn-group");
            dbtns.attr("role","group");
              
              var btn1= $("<button></button>").addClass("btn btn-default disabled");
              btn1.attr("id","reply-posted-by");
              btn1.text(posted_by);
              
              var btn2= $("<button></button>").addClass("btn btn-default disabled");
              btn2.attr("id","reply-posted-on");
              btn2.text(posted_on);

              dbtns.append(btn1);
           	  dbtns.append(btn2);

              if(<?php echo json_encode($user); ?>){

               var btn3 = $("<button><span class = 'glyphicon glyphicon-thumbs-up' aria-hidden ='true' ></span></button>").addClass("btn btn-default");         
               btn3.attr("onclick","send_like("+ID+")");


               var btn4 = $("<button><span class = 'glyphicon glyphicon-flag' aria-hidden ='true' ></span></button>").addClass("btn btn-default");         
               btn4.attr("onclick","send_abuse("+ID+")");

	            
	           dbtns.append(btn3);
	           dbtns.append(btn4);

               if(posted_by==<?php echo json_encode($user); ?>){

	                var btn5 = $("<a><span class = 'glyphicon glyphicon-pencil' aria-hidden ='true' ></span></a>").addClass("btn btn-info");         
	                btn5.attr("data-toggle","collapse" );
	                btn5.attr("href","#edit-reply-"+ID);
	                btn5.attr("aria-expanded","false");
	                btn5.attr("aria-controls","edit-reply-"+ID);

	                var btn6 = $("<button><span class = 'glyphicon glyphicon-trash' aria-hidden ='true' ></span></button>").addClass("btn btn-danger");         
	                btn6.attr("onclick","delete_post("+ID+")");

	                dbtns.append(btn5);
	                dbtns.append(btn6);
              }
            }

            DiscussDiv.append (dtitle);
            DiscussDiv.append (ddetails);
            DiscussDiv.append ("<br>");  
            DiscussDiv.append (dbtns); 

            /*
            <div id="edit-reply" class="hide">
              <form role="form" action="edit.php?editID="+ID method="POST">

                            <div class="form-group">
                                 <label>Type your reply:</label>
                                 <textarea class="form-control" rows="5" id="newinput" name="newinput" required=""></textarea>
                            </div>                           
                            
                            <input type ="submit" class="btn btn-warning" value="Save">
              </form>
            </div>

            
            */
            var editform =$("<form></form>").addClass("form collapse" );
              editform.attr("role","form");
              editform.attr("action","edit.php?editID="+ID);
              editform.attr("method","POST"); 
              editform.attr("id","edit-reply-"+ID);
              editform.attr("style","height: auto;");
           
                var editsubform =$("<div></div>").addClass("form-group");
                  var editlabel=$("<label>Type your reply:</label");
                  var editinput=$("<textarea></textarea>").addClass("form-control");
                  editinput.attr("rows","5" );
                  editinput.attr("id","newinput");
                  editinput.attr("name","newinput");
                  editinput.attr("required","");

                editsubform.append(editlabel);
                editsubform.append(editinput);

                var editsubmit=$("<input></input>").addClass("btn btn-warning");
                editsubmit.attr("type","submit");
                editsubmit.attr("value","Save");

              editform.append(editsubform);
              editform.append(editsubmit);

            DiscussDiv.append(editform);          
            
            $("#reply-post").append (DiscussDiv);
      }   

      function send_like(postID){
                var input = confirm('You have liked this post.'); //returns either true or false
                if(input)
                {
                    window.location.href = 'edit.php?likeID='+postID;                    
                } 
                else{
                    var disID = <?php echo json_encode($_SESSION['discussionID']); ?>; 
                    window.location.href = 'discussion-open.php?open='+disID;     
                }      
      }

      function send_abuse(postID){
                var input = confirm('Are you sure you want to report abuse?'); //returns either true or false
                if(input)
                {
                    window.location.href = 'edit.php?abuseID='+postID;                    
                } 
                else{
                    var disID = <?php echo json_encode($_SESSION['discussionID']); ?>; 
                    window.location.href = 'discussion-open.php?open='+disID;     
                }      
      }

 
      function delete_post(postID){
                var input = confirm('Are you sure you want to delete your post?');
                if(input)
                {
                    window.location.href = 'edit.php?deleteID='+postID; //returns either true or false                    
                } 
                else{
                    var disID = <?php echo json_encode($_SESSION['discussionID']); ?>; 
                    window.location.href = 'discussion-open.php?open='+disID;     
                }      
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





<!--Discussion-->
<div class="search-results">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">           
                

                <!-- Original Post-->
                <div id ="original-post"></div>

                <!-- Reply Post-->
                <div id="reply-post"></div> 


                
                <button type="submit" class="btn btn-danger hide"
                        id="btn-post-a-reply" onclick="showreply()">Post a Reply</button>
                

                <div id="post-a-reply" class="bs-callout bs-callout-danger hide">
                    <form role="form" action="save-reply.php" method="POST">
                            
                            <div class="form-group">
                                 <label>Type your reply:</label>
                                 <textarea class="form-control" rows="5" id="inputreply" name="inputreply" required=""></textarea>
                            </div>                           
                            
                            <input type ="submit" class="btn btn-info" value="Post">
                    </form>
                            
                </div>




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

    document.getElementById('btn-post-a-reply').setAttribute('class', 'btn btn-danger unhide');

    
}

function showreply() {
    document.getElementById('post-a-reply').setAttribute('class', 'bs-callout bs-callout-danger unhide');
}

</script>

</body>
</html>
