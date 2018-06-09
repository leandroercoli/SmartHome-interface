<?php  
error_reporting(E_ALL ^ E_NOTICE);
  if(isset($_POST['xml'])){
    $xml = $_POST['xml'];
}else{
    $xml = "default";
}
  $file = fopen("users.xml","w");
  fwrite($file, $xml);
  fclose($file);
  echo "ok";
?> 