<?php
error_reporting(0);
session_start();

require_once('session.php');
require_once('config.php');



?>

<html>
  <head>
    <title>
      Administration
    </title>
    <link rel="shortcut icon" href="img/favicon.ico" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600" rel="stylesheet" type="text/css" />
    <script src="js/skel.min.js">
    </script>
    <script src="js/init.js">
    </script>
    <script src="js/colapse.js">
    </script>
    <script src="js/popup.js">
    </script>

    <noscript>
       <link rel="stylesheet" href="css/style-wide.css"/>
    </noscript>
    
    <link rel="stylesheet" href="css/top-menu.css"/> 
  </head>
  <body>
    
    <div id="header" class="skel-panels-fixed">
      
      <div class="top">
        
        <div id="logo">
          <span class="image avatar48">
            <img src="img/avatar.jpg" alt="" />
          </span>
          <h1 id="title">
            <?=base64_decode($correctuser)?>
          </h1>
          
          <span class="byline">
            /*DiamondFox*/
          </span>
        </div>
        
        <nav id="nav">
          
        </nav>
        
      </div>
      
      <div class="bottom">
        
        <ul class="icons">
          <li>
            <a href="index.php?cmd=logout" title="Logout" class="icon icon-signout">
              <span>
              </span>
            </a>
          </li>
          <li>
            <a href="tasks.php?cd=Y2xlYW4" title="Clean Dead Bots" class="icon icon-trash">
              <span>
              </span>
            </a>
          </li>
          <li>
            <a href="#" onclick="window.open('dwn.php?cmd=compress','targetWindow','toolbar=no,location=,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=200,left=180,top=180')" title="Download All Logs" class="icon icon-download-alt">  
              <span>
              </span>
            </a>
          </li>
          
          <li>
          <a href="#" onclick="window.open('inc/spm.php','targetWindow','toolbar=no,location=,status=no,menubar=no,scrollbars=no,resizable=no,width=780,height=370,left=180,top=180')" title="Spam Options" class="icon icon-envelope">
              <span>
              </span>
            </a>
          </li>
          <li>
          <a href="#" onclick="window.open('inc/host.php','targetWindow','toolbar=no,location=,status=no,menubar=no,scrollbars=no,resizable=no,width=780,height=365,left=180,top=180')" title="DNS Redirects" class="icon icon-edit">
              <span>
              </span>
            </a>
          </li>
        </ul>
        
      </div>
      
    </div>
    
    <div id="main">
     <div class="menu">
      <ul>
        <li>
          <a href="#">Panel Security</a>
          <ul> 
           <li><a href="home.php?m=username">Change Username</a></li> 
           <li><a href="home.php?m=password">Change Password</a></li> 
           <li><a href="home.php?m=blacklist">IP Blacklist</a></li> 
          </ul> 
        </li> 

        <li>
         <a href="#">Bot Connection</a> 
         <ul> 
          <li><a href="home.php?m=agent">Change User-Agent</a></li> 
          <li><a href="home.php?m=connection">Change Connection Key</a></li> 
         </ul> 
        </li>

        <li>
         <a href="#">Services</a> 
         <ul> 
          <li><a href="home.php?m=scan">AV Checker</a></li> 
         </ul> 
       </li>

       <li>
        <a href="#">Help</a> 
        <ul> 
         <li><a href="home.php?m=help">F.A.Q</a></li> 
         <li><a href="home.php?m=commands">Commands</a></li> 
        </ul>
       </li>
   </ul>
   <br> 
 </div>
      
   <section class="four">
    <div id="content" class="clearfix">