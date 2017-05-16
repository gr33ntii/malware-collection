<?

session_start();
require_once('session.php');
include('functions.php');

$epath = $_GET['p'];
$path  = base64_decode($epath);


$ext_filter = array(
    'php',
    'php4',
    'php5'
);
$sort       = array(
    array(
        'key' => 'lname',
        'sort' => 'asc'
    ),
    array(
        'key' => 'size',
        'sort' => 'asc'
    )
);
$vWidth     = '800';
$vHeight    = '450';

$this_script = basename(__FILE__);
$this_folder = str_replace('/' . $this_script, '', $_SERVER['SCRIPT_NAME']);

$file_list   = array();
$folder_list = array();


if ($handle = opendir('./' . $path))
  {
    while (false !== ($file = readdir($handle)))
      {
        if ($file != "." && $file != ".." && $file != $this_script)
          {
            $stat = stat($path . '/' . $file);
            $info = pathinfo($path . '/' . $file);
            
            $item['name']  = $info['filename'];
            $item['lname'] = strtolower($info['filename']);
            $item['ext']   = $info['extension'];
            if ($info['extension'] == '')
                $item['ext'] = '.';
            $item['mtime'] = $stat['mtime'];
            
            
            if ($info['extension'] != '')
              {
                array_push($file_list, $item);
              }
            else
              {
                array_push($folder_list, $item);
              }
            clearstatcache();
            $total_size += $item['bytes'];
          }
      }
    closedir($handle);
  }

?>


<link rel="stylesheet" type="text/css" href="css/log.css"/>

<div class="datagrid">
  <table>
    <thead>
      <tr>
        <th align="center">
          HWID
        </th>
        <th align="center">
          Size
        </th>
        <th align="center">
          Time
        </th>
        <th align="center">
          Actions
        </th>
      </tr>
    </thead>
    
    <tbody>
      <? if($file_list): ?>
      <? foreach($file_list as $item) : ?>
      <tr class="alt">
        <td align="center">
          <img src="img/Document.png" alt="img/Document.png" />
          <?=$item['name']?>
        </td>
        <td align="center">
          <?=formatbytes($path.'/'.$item['name'].'.'.$item['ext'], "kb")?>
        </td>
        <td align="center">
          <?=time_ago($item['mtime'])?>
          old
        </td>
        <?=isDL('
        <td align="center">
          <a href="javascript:new_window('."'".$path.'/'.$item['name'].'.'.$item['ext']."'".')">
            <img src="img/save-icon.png"/>
          </a>
          &nbsp&nbsp&nbsp
          <a href="reports.php?del='.base64_encode($path.'/'.$item['name'].'.'.$item['ext']).'&pp='.$epath.'">
           <img src="img/delete-icon.png" action="?"/>
        </td>')?>
     
    </tr>
    <? endforeach; ?>
    <? endif; ?>
   </tbody>
  </table>
</div>