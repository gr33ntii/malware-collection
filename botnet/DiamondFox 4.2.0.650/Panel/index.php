<?php
session_start();
error_reporting(0);
require_once('inc/functions.php');

banned();

if (file_exists("install.php"))
  {
    header("Location: install.php");
    exit();
  }

if (isset($_GET['cmd']))
  {
    session_start();
    session_destroy();
    header('Location: index.php');
    exit();
  }

require_once('inc/config.php');

if ($_SESSION['login'])
  {
    header('Location: home.php?m=dashboard');
    exit();
  }

$user = base64_encode($_POST[user]);
$pass = md5($_POST[pass]);
if (isset($_POST['login']))
  {
    if ($user == $correctuser && $pass == $correctpass)
      {
        $_SESSION['login']    = true;
        $_SESSION['username'] = $user;
        header('Location: home.php?m=dashboard');
      }
    else
      {
        $error = '<center><img src="img/error.gif" height="170" weight="300"/></center><br>';
        $alert = '<div id="wrong" style="width:100%; padding: 10px; background:#a52a2a"><a><center><font color="white">&nbsp;Неправильный пароль!</font></center></a></div>';
      }
  }
  
  $n = rand(1,7);
  
?>

<html>
  
  <head>
    
    <meta charset="UTF-8">
    
    <title>
      вход
    </title>
    
    <script src="js/prefixfree.min.js">
  </script>
  <link rel="stylesheet" href="css/normalize.css"/>
  <link rel="stylesheet" href="css/style-login.css"/>
  
  </head>	
  
  <body>
  
   <div style="position: absolute; bottom: 0; left: 0;">
    <img src="img/title.png" width="350px"/>
   </div>
  
    <?
  	echo $alert;
    ?>
    
    <div class="login">
      
      <center>
         <?php 
	  if($error == '')
	   {
	    echo '<img src="img/banners/kartoxa'; echo $n.'.png" height="200" weight="200"/>';
	   }
	  else
	   {
	    echo $error;
	   } 
	 ?>
      </center>
      <form action="index.php" method="post">
    	<input type="text" name="user" placeholder="логин" required="required" />
      <input type="password" name="pass" placeholder="пароль" required="required" />
      <button type="submit" name="login" class="btn btn-primary btn-block btn-large">
        Войти
      </button>
    </form>
  </div>
  
  
  </body>
  
</html>