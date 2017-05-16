<link rel="stylesheet" type="text/css" href="css/gallery.css" />

<div id="container">
  <div id="gallery">

<?php

require_once('inc/config.php');

$directory = $folder.'/scr';

$allowed_types = array(
    'jpg'
);
$file_parts    = array();
$ext           = '';
$title         = '';
$i             = 0;

$dir_handle = @opendir($directory) or die("error");

while ($file = readdir($dir_handle)) {
    if ($file == '.' || $file == '..')
        continue;
    
    $file_parts = explode('.', $file);
    $ext        = strtolower(array_pop($file_parts));
    
    $title = implode('.', $file_parts);
    $title = htmlspecialchars($title);
    
    $nomargin = '';
    
    if (in_array($ext, $allowed_types)) {
        if (($i + 1) % 4 == 0)
            $nomargin = 'nomargin';
		
	echo '<img src="'.$directory.'/'.$file.'" height="500" width="900">
		<div style="background-color:#b0c4de">
			<a href="reports.php?del='.base64_encode($directory.'/'.$file).'&gg=1">
				<font color="grey">Delete '.$file.'</font>
			</a>
		</div>
		<br>';
        
        $i++;
    }
}

closedir($dir_handle);

?>

</div>