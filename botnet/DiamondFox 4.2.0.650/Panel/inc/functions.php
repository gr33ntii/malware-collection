<?php

function nice_escape($unescapedString)
{
    if (get_magic_quotes_gpc()) {
        $unescapedString = stripslashes($unescapedString);
    }
    $semiEscapedString = mysql_real_escape_string($unescapedString);
    $escapedString     = addcslashes($semiEscapedString, "%_");
    
    return $escapedString;
}

function nice_output($escapedString)
{
    $patterns        = array();
    $patterns[0]     = '/\\\%/';
    $patterns[1]     = '/\\\_/';
    $replacements    = array();
    $replacements[0] = '%';
    $replacements[1] = '_';
    $output          = preg_replace($patterns, $replacements, $escapedString);
    
    return $output;
}

function cleanstring($string)
{
    $done = nice_output(nice_escape($string));
    
    return $done;
}

function iptocountry($ip)
{
    $numbers = preg_split("/\./", $ip);
    include("ip_files/" . $numbers[0] . ".php");
    $code = ($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
    foreach ($ranges as $key => $value) {
        if ($key <= $code) {
            if ($ranges[$key][0] >= $code) {
                $two_letter_country_code = $ranges[$key][1];
                break;
            }
        }
    }
    if ($two_letter_country_code == "") {
        $two_letter_country_code = "unkown";
    }
    return $two_letter_country_code;
}



function hextostr($hex)
{
    $str = '';
    for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
        $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $str;
}

function sXOR($text, $pass)
{
    
    $var = "";
    
    for ($i = 0; $i < strlen($text); $i++) {
        $var .= chr(ord($text[$i]) ^ strlen($pass));
    }
    return htmlentities($var);
}

function compress($path, $out, $handle = false, $recursive = false)
{
    
    if (!is_dir($path) and !is_file($path))
        return false;
    
    if (!$handle) {
        $handle = new ZipArchive;
        if ($handle->open($out, ZipArchive::CREATE) === false) {
            return false;
        }
    }
    
    if (is_dir($path)) {
        $path = dirname($path . '/arch.ext');
        $handle->addEmptyDir($path);
        foreach (glob($path . '/*') as $url) {
            compress($url, $out, $handle, true);
        }
        
    } else
        $handle->addFile($path);
    
    
    if (!$recursive)
        $handle->close();
    
    return true;
}

function download_file($archivo, $downloadfilename = null)
{
    
    if (file_exists($archivo)) {
        $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $downloadfilename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivo));
        
        ob_clean();
        flush();
        readfile($archivo);
        exit;
    }
    
}

function GetBetween($content, $start, $end)
{
    $r = explode($start, $content);
    if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

function formatbytes($file, $type)
  {
    switch ($type)
    {
        case "kb":
            $filesize = filesize($file) * .0009765625;
            break;
    }
    if ($filesize <= 0)
      {
        return $filesize = '0 kb';
      }
    else
      {
        return round($filesize, 2) . ' ' . $type;
      }
  }

function time_ago($timestamp, $recursive = 0)
  {
    $current_time = time();
    $difference   = $current_time - $timestamp;
    $periods      = array(
        "second",
        "minute",
        "hour",
        "day",
        "week",
        "month",
        "year",
        "decade"
    );
    $lengths      = array(
        1,
        60,
        3600,
        86400,
        604800,
        2630880,
        31570560,
        315705600
    );
    for ($val = sizeof($lengths) - 1; ($val >= 0) && (($number = $difference / $lengths[$val]) <= 1); $val--);
    if ($val < 0)
        $val = 0;
    $new_time = $current_time - ($difference % $lengths[$val]);
    $number   = floor($number);
    if ($number != 1)
      {
        $periods[$val] .= "s";
      }
    $text = sprintf("%d %s ", $number, $periods[$val]);
    
    if (($recursive == 1) && ($val >= 1) && (($current_time - $new_time) > 0))
      {
        $text .= time_ago($new_time);
      }
    return $text;
  }

function isDL($true, $false = '')
  {
    global $ext_filter;
    
    if (!in_array('*', $ext_filter))
      {
        return $true;
      }
    else
      {
        return $false;
      }
  }

function banned()
 {
 foreach (array_values(file('inc/blacklist.php')) AS $ip)
  {
    if (trim(explode(':', $ip)[0]) == $_SERVER['REMOTE_ADDR']) 
      {
    	echo '<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL ';
	echo $_SERVER['PATH_TRANSLATED'];
	echo '/ was not found on this server.</p><hr><address>';
	echo $_SERVER['SERVER_SIGNATURE'];
	echo ' Server at ';
	echo $_SERVER['HTTP_HOST'];
	echo ' Port ';
	echo $_SERVER['SERVER_PORT'];
	echo '</address></body></html>';
    	exit;
      }
   }
 }
 
function colour($in)
{
	if ($in == 'OK')
	{
		return '<td class="tg-031e" style="text-align: center"><font color="green">'.$in.'</font></td>';
	}
	else
	{
		return '<td class="tg-031e" style="text-align: center"><font color="red">'.$in.'</font></td>';
	}
}

function colour2($in)
{
	if ($in == 0)
	{
		return '<th class="tg-031e"><font color="green">'.$in.'/35</font></th>';
	}
	else
	{
		return '<th class="tg-031e"><font color="red">'.$in.'/35</font></th>';
	}
}

Function vcc($country)
  {
    if ($country == '')
      {
        return 'Unknown';
      }
    else
      {
        return $country;
      }
  }

?>