<?php  
error_reporting(E_ALL ^ E_NOTICE);
  if(isset($_POST['xml'])){
    $xml = $_POST['xml'];
}else{
    $xml = "default";
}
  $file = fopen("currentState.xml","w");
  fwrite($file, $xml);
  fclose($file);
  echo "ok";
?> 