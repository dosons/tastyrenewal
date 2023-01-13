<?php

 $f = $_REQUEST["filename"];
 $dir = "./upload/files/".$f;
 $file_name= $f;
 Header("Content-Type: application/octet-stream");
 Header("Content-Disposition: attachment;; filename=$file_name");
 Header("Content-Transfer-Encoding: binary");
 Header("Content-Length: ".(string)(filesize($dir)));
 Header("Cache-Control: cache, must-revalidate");
 Header("Pragma: no-cache");
 Header("Expires: 0");
ob_clean();
flush();
readfile($dir);
?>
       
       
       
       
       
