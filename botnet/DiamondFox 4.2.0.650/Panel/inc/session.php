<?php

if (!$_SESSION['login'])
  {
    header('Location: index.php');
    exit();
  }

?>
